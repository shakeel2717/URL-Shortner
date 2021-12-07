/* ===================================================
 *  jquery-sortable.js v0.9.13
 *  http://johnny.github.com/jquery-sortable/
 * ===================================================
 *  Copyright (c) 2012 Jonas von Andrian
 *  All rights reserved.
 *
 *  Redistribution and use in source and binary forms, with or without
 *  modification, are permitted provided that the following conditions are met:
 *  * Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 *  * Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *  * The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 *
 *  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 *  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 *  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 *  DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 *  DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 *  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 *  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 *  ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 *  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 *  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * ========================================================== */


!function ( $, window, pluginName, undefined){
    var containerDefaults = {
      // If true, items can be dragged from this container
      drag: true,
      // If true, items can be droped onto this container
      drop: true,
      // Exclude items from being draggable, if the
      // selector matches the item
      exclude: "",
      // If true, search for nested containers within an item.If you nest containers,
      // either the original selector with which you call the plugin must only match the top containers,
      // or you need to specify a group (see the bootstrap nav example)
      nested: true,
      // If true, the items are assumed to be arranged vertically
      vertical: true
    }, // end container defaults
    groupDefaults = {
      // This is executed after the placeholder has been moved.
      // $closestItemOrContainer contains the closest item, the placeholder
      // has been put at or the closest empty Container, the placeholder has
      // been appended to.
      afterMove: function ($placeholder, container, $closestItemOrContainer) {
      },
      // The exact css path between the container and its items, e.g. "> tbody"
      containerPath: "",
      // The css selector of the containers
      containerSelector: "ol, ul",
      // Distance the mouse has to travel to start dragging
      distance: 0,
      // Time in milliseconds after mousedown until dragging should start.
      // This option can be used to prevent unwanted drags when clicking on an element.
      delay: 0,
      // The css selector of the drag handle
      handle: "",
      // The exact css path between the item and its subcontainers.
      // It should only match the immediate items of a container.
      // No item of a subcontainer should be matched. E.g. for ol>div>li the itemPath is "> div"
      itemPath: "",
      // The css selector of the items
      itemSelector: "li",
      // The class given to "body" while an item is being dragged
      bodyClass: "dragging",
      // The class giving to an item while being dragged
      draggedClass: "dragged",
      // Check if the dragged item may be inside the container.
      // Use with care, since the search for a valid container entails a depth first search
      // and may be quite expensive.
      isValidTarget: function ($item, container) {
        return true
      },
      // Executed before onDrop if placeholder is detached.
      // This happens if pullPlaceholder is set to false and the drop occurs outside a container.
      onCancel: function ($item, container, _super, event) {
      },
      // Executed at the beginning of a mouse move event.
      // The Placeholder has not been moved yet.
      onDrag: function ($item, position, _super, event) {
        $item.css(position)
      },
      // Called after the drag has been started,
      // that is the mouse button is being held down and
      // the mouse is moving.
      // The container is the closest initialized container.
      // Therefore it might not be the container, that actually contains the item.
      onDragStart: function ($item, container, _super, event) {
        $item.css({
          height: $item.outerHeight(),
          width: $item.outerWidth()
        })
        $item.addClass(container.group.options.draggedClass)
        $("body").addClass(container.group.options.bodyClass)
      },
      // Called when the mouse button is being released
      onDrop: function ($item, container, _super, event) {
        $item.removeClass(container.group.options.draggedClass).removeAttr("style")
        $("body").removeClass(container.group.options.bodyClass)
      },
      // Called on mousedown. If falsy value is returned, the dragging will not start.
      // Ignore if element clicked is input, select or textarea
      onMousedown: function ($item, _super, event) {
        if (!event.target.nodeName.match(/^(input|select|textarea)$/i)) {
          event.preventDefault()
          return true
        }
      },
      // The class of the placeholder (must match placeholder option markup)
      placeholderClass: "placeholder",
      // Template for the placeholder. Can be any valid jQuery input
      // e.g. a string, a DOM element.
      // The placeholder must have the class "placeholder"
      placeholder: '<li class="placeholder"></li>',
      // If true, the position of the placeholder is calculated on every mousemove.
      // If false, it is only calculated when the mouse is above a container.
      pullPlaceholder: true,
      // Specifies serialization of the container group.
      // The pair $parent/$children is either container/items or item/subcontainers.
      serialize: function ($parent, $children, parentIsContainer) {
        var result = $.extend({}, $parent.data())
  
        if(parentIsContainer)
          return [$children]
        else if ($children[0]){
          result.children = $children
        }
  
        delete result.subContainers
        delete result.sortable
  
        return result
      },
      // Set tolerance while dragging. Positive values decrease sensitivity,
      // negative values increase it.
      tolerance: 0
    }, // end group defaults
    containerGroups = {},
    groupCounter = 0,
    emptyBox = {
      left: 0,
      top: 0,
      bottom: 0,
      right:0
    },
    eventNames = {
      start: "touchstart.sortable mousedown.sortable",
      drop: "touchend.sortable touchcancel.sortable mouseup.sortable",
      drag: "touchmove.sortable mousemove.sortable",
      scroll: "scroll.sortable"
    },
    subContainerKey = "subContainers"
  
    /*
     * a is Array [left, right, top, bottom]
     * b is array [left, top]
     */
    function d(a,b) {
      var x = Math.max(0, a[0] - b[0], b[0] - a[1]),
      y = Math.max(0, a[2] - b[1], b[1] - a[3])
      return x+y;
    }
  
    function setDimensions(array, dimensions, tolerance, useOffset) {
      var i = array.length,
      offsetMethod = useOffset ? "offset" : "position"
      tolerance = tolerance || 0
  
      while(i--){
        var el = array[i].el ? array[i].el : $(array[i]),
        // use fitting method
        pos = el[offsetMethod]()
        pos.left += parseInt(el.css('margin-left'), 10)
        pos.top += parseInt(el.css('margin-top'),10)
        dimensions[i] = [
          pos.left - tolerance,
          pos.left + el.outerWidth() + tolerance,
          pos.top - tolerance,
          pos.top + el.outerHeight() + tolerance
        ]
      }
    }
  
    function getRelativePosition(pointer, element) {
      var offset = element.offset()
      return {
        left: pointer.left - offset.left,
        top: pointer.top - offset.top
      }
    }
  
    function sortByDistanceDesc(dimensions, pointer, lastPointer) {
      pointer = [pointer.left, pointer.top]
      lastPointer = lastPointer && [lastPointer.left, lastPointer.top]
  
      var dim,
      i = dimensions.length,
      distances = []
  
      while(i--){
        dim = dimensions[i]
        distances[i] = [i,d(dim,pointer), lastPointer && d(dim, lastPointer)]
      }
      distances = distances.sort(function  (a,b) {
        return b[1] - a[1] || b[2] - a[2] || b[0] - a[0]
      })
  
      // last entry is the closest
      return distances
    }
  
    function ContainerGroup(options) {
      this.options = $.extend({}, groupDefaults, options)
      this.containers = []
  
      if(!this.options.rootGroup){
        this.scrollProxy = $.proxy(this.scroll, this)
        this.dragProxy = $.proxy(this.drag, this)
        this.dropProxy = $.proxy(this.drop, this)
        this.placeholder = $(this.options.placeholder)
  
        if(!options.isValidTarget)
          this.options.isValidTarget = undefined
      }
    }
  
    ContainerGroup.get = function  (options) {
      if(!containerGroups[options.group]) {
        if(options.group === undefined)
          options.group = groupCounter ++
  
        containerGroups[options.group] = new ContainerGroup(options)
      }
  
      return containerGroups[options.group]
    }
  
    ContainerGroup.prototype = {
      dragInit: function  (e, itemContainer) {
        this.$document = $(itemContainer.el[0].ownerDocument)
  
        // get item to drag
        var closestItem = $(e.target).closest(this.options.itemSelector);
        // using the length of this item, prevents the plugin from being started if there is no handle being clicked on.
        // this may also be helpful in instantiating multidrag.
        if (closestItem.length) {
          this.item = closestItem;
          this.itemContainer = itemContainer;
          if (this.item.is(this.options.exclude) || !this.options.onMousedown(this.item, groupDefaults.onMousedown, e)) {
              return;
          }
          this.setPointer(e);
          this.toggleListeners('on');
          this.setupDelayTimer();
          this.dragInitDone = true;
        }
      },
      drag: function  (e) {
        if(!this.dragging){
          if(!this.distanceMet(e) || !this.delayMet)
            return
  
          this.options.onDragStart(this.item, this.itemContainer, groupDefaults.onDragStart, e)
          this.item.before(this.placeholder)
          this.dragging = true
        }
  
        this.setPointer(e)
        // place item under the cursor
        this.options.onDrag(this.item,
                            getRelativePosition(this.pointer, this.item.offsetParent()),
                            groupDefaults.onDrag,
                            e)
  
        var p = this.getPointer(e),
        box = this.sameResultBox,
        t = this.options.tolerance
  
        if(!box || box.top - t > p.top || box.bottom + t < p.top || box.left - t > p.left || box.right + t < p.left)
          if(!this.searchValidTarget()){
            this.placeholder.detach()
            this.lastAppendedItem = undefined
          }
      },
      drop: function  (e) {
        this.toggleListeners('off')
  
        this.dragInitDone = false
  
        if(this.dragging){
          // processing Drop, check if placeholder is detached
          if(this.placeholder.closest("html")[0]){
            this.placeholder.before(this.item).detach()
          } else {
            this.options.onCancel(this.item, this.itemContainer, groupDefaults.onCancel, e)
          }
          this.options.onDrop(this.item, this.getContainer(this.item), groupDefaults.onDrop, e)
  
          // cleanup
          this.clearDimensions()
          this.clearOffsetParent()
          this.lastAppendedItem = this.sameResultBox = undefined
          this.dragging = false
        }
      },
      searchValidTarget: function  (pointer, lastPointer) {
        if(!pointer){
          pointer = this.relativePointer || this.pointer
          lastPointer = this.lastRelativePointer || this.lastPointer
        }
  
        var distances = sortByDistanceDesc(this.getContainerDimensions(),
                                           pointer,
                                           lastPointer),
        i = distances.length
  
        while(i--){
          var index = distances[i][0],
          distance = distances[i][1]
  
          if(!distance || this.options.pullPlaceholder){
            var container = this.containers[index]
            if(!container.disabled){
              if(!this.$getOffsetParent()){
                var offsetParent = container.getItemOffsetParent()
                pointer = getRelativePosition(pointer, offsetParent)
                lastPointer = getRelativePosition(lastPointer, offsetParent)
              }
              if(container.searchValidTarget(pointer, lastPointer))
                return true
            }
          }
        }
        if(this.sameResultBox)
          this.sameResultBox = undefined
      },
      movePlaceholder: function  (container, item, method, sameResultBox) {
        var lastAppendedItem = this.lastAppendedItem
        if(!sameResultBox && lastAppendedItem && lastAppendedItem[0] === item[0])
          return;
  
        item[method](this.placeholder)
        this.lastAppendedItem = item
        this.sameResultBox = sameResultBox
        this.options.afterMove(this.placeholder, container, item)
      },
      getContainerDimensions: function  () {
        if(!this.containerDimensions)
          setDimensions(this.containers, this.containerDimensions = [], this.options.tolerance, !this.$getOffsetParent())
        return this.containerDimensions
      },
      getContainer: function  (element) {
        return element.closest(this.options.containerSelector).data(pluginName)
      },
      $getOffsetParent: function  () {
        if(this.offsetParent === undefined){
          var i = this.containers.length - 1,
          offsetParent = this.containers[i].getItemOffsetParent()
  
          if(!this.options.rootGroup){
            while(i--){
              if(offsetParent[0] != this.containers[i].getItemOffsetParent()[0]){
                // If every container has the same offset parent,
                // use position() which is relative to this parent,
                // otherwise use offset()
                // compare #setDimensions
                offsetParent = false
                break;
              }
            }
          }
  
          this.offsetParent = offsetParent
        }
        return this.offsetParent
      },
      setPointer: function (e) {
        var pointer = this.getPointer(e)
  
        if(this.$getOffsetParent()){
          var relativePointer = getRelativePosition(pointer, this.$getOffsetParent())
          this.lastRelativePointer = this.relativePointer
          this.relativePointer = relativePointer
        }
  
        this.lastPointer = this.pointer
        this.pointer = pointer
      },
      distanceMet: function (e) {
        var currentPointer = this.getPointer(e)
        return (Math.max(
          Math.abs(this.pointer.left - currentPointer.left),
          Math.abs(this.pointer.top - currentPointer.top)
        ) >= this.options.distance)
      },
      getPointer: function(e) {
        var o = e.originalEvent || e.originalEvent.touches && e.originalEvent.touches[0]
        return {
          left: e.pageX || o.pageX,
          top: e.pageY || o.pageY
        }
      },
      setupDelayTimer: function () {
        var that = this
        this.delayMet = !this.options.delay
  
        // init delay timer if needed
        if (!this.delayMet) {
          clearTimeout(this._mouseDelayTimer);
          this._mouseDelayTimer = setTimeout(function() {
            that.delayMet = true
          }, this.options.delay)
        }
      },
      scroll: function  (e) {
        this.clearDimensions()
        this.clearOffsetParent() // TODO is this needed?
      },
      toggleListeners: function (method) {
        var that = this,
        events = ['drag','drop','scroll']
  
        $.each(events,function  (i,event) {
          that.$document[method](eventNames[event], that[event + 'Proxy'])
        })
      },
      clearOffsetParent: function () {
        this.offsetParent = undefined
      },
      // Recursively clear container and item dimensions
      clearDimensions: function  () {
        this.traverse(function(object){
          object._clearDimensions()
        })
      },
      traverse: function(callback) {
        callback(this)
        var i = this.containers.length
        while(i--){
          this.containers[i].traverse(callback)
        }
      },
      _clearDimensions: function(){
        this.containerDimensions = undefined
      },
      _destroy: function () {
        containerGroups[this.options.group] = undefined
      }
    }
  
    function Container(element, options) {
      this.el = element
      this.options = $.extend( {}, containerDefaults, options)
  
      this.group = ContainerGroup.get(this.options)
      this.rootGroup = this.options.rootGroup || this.group
      this.handle = this.rootGroup.options.handle || this.rootGroup.options.itemSelector
  
      var itemPath = this.rootGroup.options.itemPath
      this.target = itemPath ? this.el.find(itemPath) : this.el
  
      this.target.on(eventNames.start, this.handle, $.proxy(this.dragInit, this))
  
      if(this.options.drop)
        this.group.containers.push(this)
    }
  
    Container.prototype = {
      dragInit: function  (e) {
        var rootGroup = this.rootGroup
  
        if( !this.disabled &&
            !rootGroup.dragInitDone &&
            this.options.drag &&
            this.isValidDrag(e)) {
          rootGroup.dragInit(e, this)
        }
      },
      isValidDrag: function(e) {
        return e.which == 1 ||
          e.type == "touchstart" && e.originalEvent.touches.length == 1
      },
      searchValidTarget: function  (pointer, lastPointer) {
        var distances = sortByDistanceDesc(this.getItemDimensions(),
                                           pointer,
                                           lastPointer),
        i = distances.length,
        rootGroup = this.rootGroup,
        validTarget = !rootGroup.options.isValidTarget ||
          rootGroup.options.isValidTarget(rootGroup.item, this)
  
        if(!i && validTarget){
          rootGroup.movePlaceholder(this, this.target, "append")
          return true
        } else
          while(i--){
            var index = distances[i][0],
            distance = distances[i][1]
            if(!distance && this.hasChildGroup(index)){
              var found = this.getContainerGroup(index).searchValidTarget(pointer, lastPointer)
              if(found)
                return true
            }
            else if(validTarget){
              this.movePlaceholder(index, pointer)
              return true
            }
          }
      },
      movePlaceholder: function  (index, pointer) {
        var item = $(this.items[index]),
        dim = this.itemDimensions[index],
        method = "after",
        width = item.outerWidth(),
        height = item.outerHeight(),
        offset = item.offset(),
        sameResultBox = {
          left: offset.left,
          right: offset.left + width,
          top: offset.top,
          bottom: offset.top + height
        }
        if(this.options.vertical){
          var yCenter = (dim[2] + dim[3]) / 2,
          inUpperHalf = pointer.top <= yCenter
          if(inUpperHalf){
            method = "before"
            sameResultBox.bottom -= height / 2
          } else
            sameResultBox.top += height / 2
        } else {
          var xCenter = (dim[0] + dim[1]) / 2,
          inLeftHalf = pointer.left <= xCenter
          if(inLeftHalf){
            method = "before"
            sameResultBox.right -= width / 2
          } else
            sameResultBox.left += width / 2
        }
        if(this.hasChildGroup(index))
          sameResultBox = emptyBox
        this.rootGroup.movePlaceholder(this, item, method, sameResultBox)
      },
      getItemDimensions: function  () {
        if(!this.itemDimensions){
          this.items = this.$getChildren(this.el, "item").filter(
            ":not(." + this.group.options.placeholderClass + ", ." + this.group.options.draggedClass + ")"
          ).get()
          setDimensions(this.items, this.itemDimensions = [], this.options.tolerance)
        }
        return this.itemDimensions
      },
      getItemOffsetParent: function  () {
        var offsetParent,
        el = this.el
        // Since el might be empty we have to check el itself and
        // can not do something like el.children().first().offsetParent()
        if(el.css("position") === "relative" || el.css("position") === "absolute"  || el.css("position") === "fixed")
          offsetParent = el
        else
          offsetParent = el.offsetParent()
        return offsetParent
      },
      hasChildGroup: function (index) {
        return this.options.nested && this.getContainerGroup(index)
      },
      getContainerGroup: function  (index) {
        var childGroup = $.data(this.items[index], subContainerKey)
        if( childGroup === undefined){
          var childContainers = this.$getChildren(this.items[index], "container")
          childGroup = false
  
          if(childContainers[0]){
            var options = $.extend({}, this.options, {
              rootGroup: this.rootGroup,
              group: groupCounter ++
            })
            childGroup = childContainers[pluginName](options).data(pluginName).group
          }
          $.data(this.items[index], subContainerKey, childGroup)
        }
        return childGroup
      },
      $getChildren: function (parent, type) {
        var options = this.rootGroup.options,
        path = options[type + "Path"],
        selector = options[type + "Selector"]
  
        parent = $(parent)
        if(path)
          parent = parent.find(path)
  
        return parent.children(selector)
      },
      _serialize: function (parent, isContainer) {
        var that = this,
        childType = isContainer ? "item" : "container",
  
        children = this.$getChildren(parent, childType).not(this.options.exclude).map(function () {
          return that._serialize($(this), !isContainer)
        }).get()
  
        return this.rootGroup.options.serialize(parent, children, isContainer)
      },
      traverse: function(callback) {
        $.each(this.items || [], function(item){
          var group = $.data(this, subContainerKey)
          if(group)
            group.traverse(callback)
        });
  
        callback(this)
      },
      _clearDimensions: function  () {
        this.itemDimensions = undefined
      },
      _destroy: function() {
        var that = this;
  
        this.target.off(eventNames.start, this.handle);
        this.el.removeData(pluginName)
  
        if(this.options.drop)
          this.group.containers = $.grep(this.group.containers, function(val){
            return val != that
          })
  
        $.each(this.items || [], function(){
          $.removeData(this, subContainerKey)
        })
      }
    }
  
    var API = {
      enable: function() {
        this.traverse(function(object){
          object.disabled = false
        })
      },
      disable: function (){
        this.traverse(function(object){
          object.disabled = true
        })
      },
      serialize: function () {
        return this._serialize(this.el, true)
      },
      refresh: function() {
        this.traverse(function(object){
          object._clearDimensions()
        })
      },
      destroy: function () {
        this.traverse(function(object){
          object._destroy();
        })
      }
    }
  
    $.extend(Container.prototype, API)
  
    /**
     * jQuery API
     *
     * Parameters are
     *   either options on init
     *   or a method name followed by arguments to pass to the method
     */
    $.fn[pluginName] = function(methodOrOptions) {
      var args = Array.prototype.slice.call(arguments, 1)
  
      return this.map(function(){
        var $t = $(this),
        object = $t.data(pluginName)
  
        if(object && API[methodOrOptions])
          return API[methodOrOptions].apply(object, args) || this
        else if(!object && (methodOrOptions === undefined ||
                            typeof methodOrOptions === "object"))
          $t.data(pluginName, new Container($t, methodOrOptions))
  
        return this
      });
    };
  
  }(jQuery, window, 'sortable');

$(document).ready(function(){

    $('#linkcontent').sortable({
        containerSelector: "#linkcontent",
        handle: '.handle',
        itemSelector: '.sortable',
        placeholder: '<div class="card p-4 bg-secondary shadow-none border"></div>',
        onMousedown: function ($item, _super, event) {
          if (!event.target.nodeName.match(/^(input|select|textarea)$/i)) {
            event.preventDefault()
            before = $item.index();
            return true
          }
        },
        onDrop: function($item, container, _super, event) {
            $item.removeClass(container.group.options.draggedClass).removeAttr("style")
            $("body").removeClass(container.group.options.bodyClass)
            after = $item.index();
            lafter = $('#preview #content .item:eq('+after+')');
            lebefore = $('#preview #content .item:eq('+before+')');

            lafter.replaceWith(lebefore);
            if(before > after)
                lebefore.after(lafter);
            else
                lebefore.before(lafter);
        }
    });

    $('[data-trigger=insertcontent]').click(function(e){
        e.preventDefault();
        let callback = 'fn'+$(this).data('type');
        $('.alt-error').remove();
        if(callback !== undefined){
			let html = window[callback]($(this));            
            if(html === false) return;
            $("#linkcontent").append(html);
            $("#contentModal div").removeClass('show');
            $("#options").addClass('show');
            $("#contentModal .btn-close").click();            
		} 
    });

    $(document).on('click','[data-trigger=removeCard]', function(e){
        e.preventDefault();
        let id = $(this).parent('.card').data('id');
        $(this).parent('.card').remove();
        $("#preview").find('#'+id).remove();
    });
    
    changeTheme("#fffff", "#fffff", "#fffff", "#000000", "#ffffff", "#0000000");

    $("[data-trigger=changeTheme]").click(function(e){
        e.preventDefault();
    });
    $("input[name=name]").keyup(function(){
        let val = $(this).val();
        $("#preview h3 > span").text(val);
    });

    $('#avatar').change(function(){
        var files = $(this).prop('files');

        for (var i = 0, f; f = files[i]; i++) {
    
          // Only process image files.
          if (!f.type.match('image.*')) {
            continue;
          }
    
          var reader = new FileReader();
    
          reader.onload = (function() {
            return function(e) {
              $('#useravatar, #preview #userimage').attr('src', e.target.result);
            }
          })(f);
    
          // Read in the image file as a data URL.
          reader.readAsDataURL(f);
        }
    });

    $('form').submit(function(e){
        e.preventDefault();
        let action = $(this).attr('action');
        let valid = true;

        $('.form-control').removeClass('is-invalid');

        $(this).find('[required]').each(function(){
            
            let min = $(this).attr('min') ? $(this).attr('min') : 3;

            if($(this).val().length < min){
                valid = false;
                $(this).addClass('is-invalid');
                if($(this).data('error')) {
                    $.notify({
                        message: $(this).data('error')
                    },{
                        type: 'danger',
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                    });
                }
            }
        });
        
        if(valid == false) return false;
        let data = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: action,
            data: data,
			contentType: false,
			processData: false,            
            dataType: 'json',
            beforeSend: function(){
                $('body').append('<div class="preloader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            complete: function(){
                $('.preloader').remove();
            },
            success: function(response){
                $('input[name=_token]').val(response.token);
                if(response.error){
                    $.notify({
                        message: response.message
                    },{
                        type: 'danger',
                        placement: {
                            from: "top",
                            align: "right"
                        },
                    });
                } else {
                    $.notify({
                        message: response.message
                    },{
                        type: 'success',
                        placement: {
                            from: "top",
                            align: "right"
                        },
                    });
                    if(response.html){
                        $('body').append(response.html);
                    }
                    $(this).find('input,textarea,select').val('');
                }
            }
        });
    });
});

function bgColor(element, color, e) {
    $(element).css("background-color", (color ? color.toHexString() : ""));
    e.val(color.toHexString());
}

function Color(element, color, e) {
    $(element).css("color", (color ? color.toHexString() : ""));
    e.val(color.toHexString());
}	

function gradient(element, color, e) {
    e.val(color.toHexString());
    let start = $('#bgst').val();
    let stop = $('#bgsp').val();
    $(element).attr("style", 'background:linear-gradient(0deg, '+start+' 0%, '+stop+' 100%);');
}	

function changeTheme(bg, bgst, bgsp, buttoncolor, buttontextcolor, textcolor){
    $('#preview .card').css("background-color", bg);
    $("#bg").val(bg);
    $('#preview .btn-custom').css("background-color", buttoncolor);
    $("#buttoncolor").val(buttoncolor);
    $("#preview .btn-custom").css("color", buttontextcolor);
    $("#buttontextcolor").val(buttontextcolor);
    $("#preview h3 > span, #preview p").css("color", textcolor);
    $("#textcolor").val(textcolor);
    $("#preview .card").attr("style", 'background:linear-gradient(0deg, '+bgst+' 0%, '+bgsp+' 100%);');
    $("#bgst").val(bgst);
    $("#bgsp").val(bgsp);

    $("#bg").spectrum({
        color: bg,
        showInput: true,
        preferredFormat: "hex",                
        move: function (color) { bgColor("#preview .card", color, $(this)); },
        hide: function (color) { bgColor("#preview .card", color, $(this)); }                                
    });	
    $("#bgst").spectrum({
        color: bgst,
        showInput: true,
        preferredFormat: "hex",                
        move: function (color) { gradient("#preview .card", color, $(this)); },
        hide: function (color) { gradient("#preview .card", color, $(this)); }            
    });
    $("#bgsp").spectrum({
        color: bgsp,
        showInput: true,
        preferredFormat: "hex",                
        move: function (color) { gradient("#preview .card", color, $(this)); },
        hide: function (color) { gradient("#preview .card", color, $(this)); }            
    });
    $("#buttontextcolor").spectrum({
        color: buttontextcolor,
        showInput: true,
        preferredFormat: "hex",                
        move: function (color) { Color("#preview .btn-custom", color, $(this)); },
        hide: function (color) { Color("#preview .btn-custom", color, $(this)); }   
    });     
    $("#buttoncolor").spectrum({
        color: buttoncolor,
        showInput: true,
        allowEmpty: true,
        preferredFormat: "hex",                
        move: function (color) { bgColor("#preview .btn-custom", color, $(this)); },
        hide: function (color) { bgColor("#preview .btn-custom", color, $(this)); }   
    });
    $("#textcolor").spectrum({
        color: textcolor,
        showInput: true,
        preferredFormat: "hex",        
        move: function (color) { Color("#preview h3 > span, #preview p", color, $(this)); },
        hide: function (color) { Color("#preview h3 > span  #preview p", color, $(this)); }           
    });    
}
function fntext(el, content = null){

    if(content){
        var text = content['text'];
    } else {
        let eltext = el.parent("#modal-text").find('textarea[name=content]');
             
        var text = eltext.val();
        eltext.val('');
    }
    
    let did = (Math.random() + 1).toString(36).substring(2);
    let html = '<div class="card p-2 shadow-none border position-relative sortable" data-id="'+did+'">'+
                    '<a class="position-absolute top-0 end-0 me-2" data-trigger="removeCard" href=""><i class="fa fa-times-circle"></i></a>'+
                    '<h5><i class="fa fa-align-justify handle mr-2"></i> '+el.parent(".collapse").data('name')+'</h5>'+
                    '<div class="row mt-2">'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="hidden" name="data['+slug(text)+'][type]" value="text">'+
                                '<textarea class="form-control p-2" name="data['+slug(text)+'][text]" placeholder="e.g. some description here">'+text+'</textarea>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';

            $('#content').append('<div class="item"><p id="'+did+'">'+text+'</p></div>');

        return html;
}
function fnlink(el, content = null){
    let regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;

    if(content){
        var text = content['text'];
        var link = content['link'];
    } else {
        let eltext = el.parent("#modal-links").find('input[name=text]');
        let ellink = el.parent("#modal-links").find('input[name=link]');
    
        if(!regex.test(ellink.val())){
            ellink.after('<p class="alt-error text-danger mt-2">'+ellink.data('error')+'</p>');
            return false;
        }                
        var text = eltext.val();
        var link = ellink.val();
        ellink.val('');
        eltext.val('');        
    }
    
    let did = (Math.random() + 1).toString(36).substring(2);
    let html = '<div class="card p-2 shadow-none border position-relative sortable" data-id="'+did+'">'+
                    '<a class="position-absolute top-0 end-0 me-2" data-trigger="removeCard" href=""><i class="fa fa-times-circle"></i></a>'+
                    '<h5><i class="fa fa-align-justify handle mr-2"></i> '+el.parent(".collapse").data('name')+'</h5>'+
                    '<div class="row mt-2">'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(text)+'][text]" value="'+text+'" placeholder="e.g. My Site">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="hidden" name="data['+slug(text)+'][type]" value="link">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(text)+'][link]" value="'+link+'" placeholder="e.g. https://">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';

            $('#content').append('<div class="item"><a href="#" id="'+did+'" class="btn w-100 btn-custom mb-2 p-2">'+text+'</a></div>');

        return html;
}
function fnyoutube(el, content = null){

    let regex = /http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/i;

    if(content){
        var link = content['link'];
    } else {
        let ellink = el.parent("#modal-youtube").find('input[name=link]');

        if(!regex.test(ellink.val())){
            ellink.after('<p class="alt-error text-danger mt-2">'+ellink.data('error')+'</p>');
            return false;
        }
        var link = ellink.val();
        ellink.val('');
    }
    
    let did = (Math.random() + 1).toString(36).substring(2);
    let html = '<div class="card p-2 shadow-none border position-relative sortable" data-id="'+did+'">'+
                    '<a class="position-absolute top-0 end-0 me-2" data-trigger="removeCard" href=""><i class="fa fa-times-circle"></i></a>'+
                    '<h5><i class="fa fa-align-justify handle mr-2"></i> '+el.parent(".collapse").data('name')+'</h5>'+
                    '<div class="row mt-2">'+                        
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="hidden" name="data['+slug(link)+'][type]" value="youtube">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(link)+'][link]" value="'+link+'" placeholder="e.g. https://">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';  
                
        let id = link.match(regex);
        $('#content').append('<div class="item"><iframe id="'+did+'" class="rounded mb-2" src="https://www.youtube.com/embed/'+id[1]+'" width="100%" height="200"></iframe></div>');
    return html;
}
function fnwhatsapp(el, content = null){
    if(content){
        var text = content['label'];
        var link = content['phone'];
    } else {
        let ellink = el.parent("#modal-whatsapp").find('input[name=phone]');
        let eltext = el.parent("#modal-whatsapp").find('input[name=label]');
        if(ellink.val().length < 0){
            ellink.after('<p class="alt-error text-danger mt-2">'+ellink.data('error')+'</p>');
            return false;
        }        
        var text = eltext.val();
        var link = ellink.val();
        ellink.val('');
        eltext.val('');        
    }

    
    let did = (Math.random() + 1).toString(36).substring(2);
    let html = '<div class="card p-2 shadow-none border position-relative sortable" data-id="'+did+'">'+
                    '<a class="position-absolute top-0 end-0 me-2" data-trigger="removeCard" href=""><i class="fa fa-times-circle"></i></a>'+
                    '<h5><i class="fa fa-align-justify handle mr-2"></i> '+el.parent(".collapse").data('name')+'</h5>'+
                    '<div class="row mt-2">'+                           
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="hidden" name="data['+slug(link)+'][type]" value="whatsapp">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(link)+'][phone]" value="'+link+'" placeholder="">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(link)+'][label]" value="'+text+'" placeholder="">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';    

        $('#content').append('<div class="item"><a href="#" id="'+did+'" class="btn w-100 btn-custom mb-2 p-2">'+text+'</a></div>');
    return html;
}
function fnspotify(el, content = null){
    let regex = /^https:\/\/open.spotify.com\/track\/([a-zA-Z0-9]+)(.*)$/i;

    if(content){
        var link = content['link'];
    } else {
        let ellink = el.parent("#modal-spotify").find('input[name=link]');

        if(!regex.test(ellink.val())){
            ellink.after('<p class="alt-error text-danger mt-2">'+ellink.data('error')+'</p>');
            return false;
        }        
        var link = ellink.val();
        ellink.val('');
    }
    
    let did = (Math.random() + 1).toString(36).substring(2);
    let html = '<div class="card p-2 shadow-none border position-relative sortable" data-id="'+did+'">'+
                    '<a class="position-absolute top-0 end-0 me-2" data-trigger="removeCard" href=""><i class="fa fa-times-circle"></i></a>'+
                    '<h5><i class="fa fa-align-justify handle mr-2"></i> '+el.parent(".collapse").data('name')+'</h5>'+
                    '<div class="row mt-2">'+                           
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="hidden" name="data['+slug(link)+'][type]" value="spotify">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(link)+'][link]" value="'+link+'" placeholder="e.g. https://">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';   
                
        $('#content').append('<div class="item"><iframe id="'+did+'" class="rounded mb-2" src="'+link.replace('/track/', '/embed/track/')+'" width="100%" height="200"></iframe></div>');
    return html;
}
function fnitunes(el, content = null){
    let regex = /^https:\/\/music.apple.com\/(.*)/i;
    if(content){
        var link = content['link'];
    } else {
        let ellink = el.parent("#modal-itunes").find('input[name=link]');    

        if(!regex.test(ellink.val())){
            ellink.after('<p class="alt-error text-danger mt-2">'+ellink.data('error')+'</p>');
            return false;
        }
        var link = ellink.val();
        ellink.val('');
    }

    let did = (Math.random() + 1).toString(36).substring(2);
    let html = '<div class="card p-2 shadow-none border position-relative sortable" data-id="'+did+'">'+
                    '<a class="position-absolute top-0 end-0 me-2" data-trigger="removeCard" href=""><i class="fa fa-times-circle"></i></a>'+
                    '<h5><i class="fa fa-align-justify handle mr-2"></i> '+el.parent(".collapse").data('name')+'</h5>'+
                    '<div class="row mt-2">'+                           
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="hidden" name="data['+slug(link)+'][type]" value="itunes">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(link)+'][link]" value="'+link+'" placeholder="e.g. https://">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
        $('#content').append('<div class="item"><iframe id="'+did+'" class="rounded mb-2" src="'+link.replace('music.apple', 'embed.music.apple')+'" width="100%" height="200"></iframe></div>');
    return html;
}
function fnpaypal(el, content = null){
    if(content){
        var label = content['label'];
        var email = content['email'];
        var amount = content['amount'];
        var currency = content['currency'];
    } else {
        let ellabel = el.parent("#modal-paypal").find('input[name=label]');
        let elemail = el.parent("#modal-paypal").find('input[name=email]');
        let elamount = el.parent("#modal-paypal").find('input[name=amount]');
        let elcurrency = el.parent("#modal-paypal").find('select[name=currency]');

        var label = ellabel.val();
        var email = elemail.val();
        var amount = elamount.val();
        var currency = elcurrency.val();

        ellabel.val('');
        elemail.val('');
        elamount.val('');
    }
    
    let did = (Math.random() + 1).toString(36).substring(2);
    let html = '<div class="card p-2 shadow-none border position-relative sortable" data-id="'+did+'">'+
                    '<a class="position-absolute top-0 end-0 me-2" data-trigger="removeCard" href=""><i class="fa fa-times-circle"></i></a>'+
                    '<h5><i class="fa fa-align-justify handle mr-2"></i> '+el.parent(".collapse").data('name')+'</h5>'+
                    '<div class="row mt-2">'+                           
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="hidden" name="data['+slug(label)+'][type]" value="paypal">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(label)+'][label]" value="'+label+'">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(label)+'][email]" value="'+email+'">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row mt-2">'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(label)+'][amount]" value="'+amount+'">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+                            
                            '<div class="form-group">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(label)+'][currency]" value="'+currency+'">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
        $('#content').append('<div class="item"><a href="#" id="'+did+'" class="btn w-100 btn-custom mb-2 p-2">'+label+'</a></div>');
    return html;
}
function fntiktok(el, content = null){
    
    let regex = /^https?:\/\/(?:www|m)\.(?:tiktok.com)\/(.*)\/video\/(.*)/i;

    if(content){
        var link = content['link'];
    } else {
        let ellink = el.parent("#modal-tiktok").find('input[name=link]');            
        
        if(!regex.test(ellink.val())){
            ellink.after('<p class="alt-error text-danger mt-2">'+ellink.data('error')+'</p>');
            return false;
        }

        var link = ellink.val();
        ellink.val('');
    }
    
    let did = (Math.random() + 1).toString(36).substring(2);
    let html = '<div class="card p-2 shadow-none border position-relative sortable" data-id="'+did+'">'+
                    '<a class="position-absolute top-0 end-0 me-2" data-trigger="removeCard" href=""><i class="fa fa-times-circle"></i></a>'+
                    '<h5><i class="fa fa-align-justify handle mr-2"></i> '+el.parent(".collapse").data('name')+'</h5>'+
                    '<div class="row mt-2">'+                           
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<input type="hidden" name="data['+slug(link)+'][type]" value="tiktok">'+
                                '<input type="text" class="form-control p-2" name="data['+slug(link)+'][link]" value="'+link+'" placeholder="e.g. https://">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
        let id = link.match(regex);
        $('#content').append('<div class="item"><div id="'+did+'"><blockquote class="tiktok-embed rounded" cite="'+link+'" data-video-id="'+id[2]+'" style="max-width: 605px;min-width: 325px;" > <section> </section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script></div></div>');
    return html;
}
function bioupdate(){
    for(bio in biodata){
        let callback = 'fn'+biodata[bio]['type'];
        let html = window[callback]($('[data-type='+biodata[bio]['type']+']'), biodata[bio]);
        $("#linkcontent").append(html);
    }
}

function slug(str) {
    
    str = encodeURIComponent(str);
    str = str.replace(/^\s+|\s+$/g, '');
    str = str.toLowerCase();
  
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to   = "aaaaeeeeiiiioooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');

    return "B"+str;
}