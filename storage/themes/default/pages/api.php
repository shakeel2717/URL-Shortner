<section id="top">
    <div class="container-fluid">
        <div class="row row-grid">
            <div class="col-md-2 px-0">
                <div class="list-group list-group-flush">
                    <a href="#started" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <div>
                            <span><?php ee('Getting Started') ?></span>
                        </div>
                        <div><i data-feather="chevron-right"></i></div>
                    </a>  
                    <a href="#auth" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <div>
                            <span><?php ee('Authentication') ?></span>
                        </div>
                        <div><i data-feather="chevron-right"></i></div>
                    </a> 
                    <a href="#rate" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <div>
                            <span><?php ee('Rate Limit') ?></span>
                        </div>
                        <div><i data-feather="chevron-right"></i></div>
                    </a>  
                    <a href="#response" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <div>
                            <span><?php ee('Response Handling') ?></span>
                        </div>
                        <div><i data-feather="chevron-right"></i></div>
                    </a> 
                    <?php foreach($menu as $id => $el): ?>
                        <h6 class="px-3 pt-3"><i data-feather="plus-circle" class="mr-1"></i> <a href="#<?php echo $id ?>" data-target="#holder-<?php echo $id ?>" data-toggle="collapse"><?php echo $el['title'] ?></a></h6>                    
                        <div class="collapse" id="holder-<?php echo $id ?>">
                            <?php foreach($el['endpoints'] as $anchor => $title): ?>
                                <a href="#<?php echo $anchor ?>" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                                    <div>
                                        <span><?php echo $title ?></span>
                                    </div>
                                    <div><i data-feather="chevron-right"></i></div>
                                </a>                            
                            <?php endforeach ?>                                                   
                        </div>  
                    <?php endforeach ?>
                </div>
            </div>
            <div class="col-md-10 ml-lg-auto py-5 border-left">
                <div class="mb-5" id="getting-started">
                    <div class="row mb-5">
                        <div class="col-lg-7">
                            <h4 class="mb-5 px-4"><?php ee('API Reference for Developers') ?> <span class="badge badge-success text-sm align-middle">v3</span></h4>
                            <div class="card-header py-4">
                                <h6 class="mb-0" id="started"><i data-feather="terminal" class="mr-3"></i><?php ee('Getting Started') ?></h6>
                            </div>
                            <div class="card-body">
                                <p><?php ee("An API key is required for requests to be processed by the system. Once a user registers, an API key is automatically generated for this user. The API key must be sent with each request (see full example below). If the API key is not sent or is expired, there will be an error. Please make sure to keep your API key secret to prevent abuse.") ?></p>                                                                                    
                            </div>                     
                        </div>
                        <div class="col-lg-5">
                            <?php if(\Core\Auth::logged() && \Core\Auth::user()->has('api') && \Core\Auth::user()->teamPermission('api.create')): ?>
                                <div class="mt-8">
                                    <p><strong><?php ee("Your API key") ?></strong></p>
                                    <pre class="code bg-secondary rounded p-3"><span><?php echo $token ?></span></pre>
                                    <a href="<?php echo route('settings') ?>" class="btn btn-primary btn-sm delete" title="<?php ee("Regenerate API Key") ?>" data-content="<?php ee("If you proceed, your current applications will not work anymore. You will need to change your api key for it to work again.") ?>"><?php ee("Regenerate") ?></a>    
                                </div>                                
                            <?php endif ?>
                        </div>
                    </div>                   
                </div> 
                <div class="mb-5" id="authentication">
                    <div class="row mb-5">
                        <div class="col-md-7">                     
                            <div class="card-header py-4">
                                <h6 class="mb-0" id="auth"><i data-feather="terminal" class="mr-3"></i><?php ee('Authentication') ?></h6>
                            </div>
                            <div class="card-body">
                                <p><?php ee("To authenticate with the API system, you need to send your API key as an authorization token with each request. You can see sample code below.") ?></p>                                   
                            </div>                         
                        </div>
                        <div class="col-md-5">
                            <div class="mt-8 p-3 bg-secondary rounded">
                                <div class="btn-group code-lang mb-3">
                                    <a href="#curl" class="btn btn-dark btn-xs active">cURL</a>
                                    <a href="#php" class="btn btn-dark btn-xs">PHP</a>
                                </div>
                                <div class="code-selector" data-id="curl">
                                    <pre><code class="rounded bash"><?php echo str_replace("                  ","", "curl --location --request POST '".route('api.url.create')."' \ 
                                    --header 'Authorization: Bearer {$token}
                                    --header 'Content-Type: application/json' \ ") ?></code></pre>                
                                </div>
                                <div class="code-selector" data-id="php">
                                    <pre><code class="rounded php"><?php echo str_replace("                  ","", '$curl = curl_init();
                                    curl_setopt_array($curl, array(
                                        CURLOPT_URL => "'.route('api.url.create').'",
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => "",
                                        CURLOPT_MAXREDIRS => 2,
                                        CURLOPT_TIMEOUT => 10,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_CUSTOMREQUEST => "POST",
                                        CURLOPT_HTTPHEADER => array(
                                        "Authorization: Bearer '.$token.'",
                                        "Content-Type: application/json",
                                        ),
                                    ));

                                    $response = curl_exec($curl);') ?></code></pre>                
                                </div>
                            </div>
                        </div>
                    </div>                   
                </div>                
                <div id="ratelimit" class="row mb-5">
                    <div class="col-lg-7">
                        <div class="card-header py-4">
                            <h6 class="mb-0" id="rate"><i data-feather="terminal" class="mr-3"></i><?php ee('Rate Limit') ?></h6>
                        </div>
                        <div class="card-body">
                            <p><?php ee("Our API has a rate limiter to safeguard against spike in requests to maximize its stability. Our rate limiter is currently caped at {x} requests per {y} minute.", null, ['x' => $rate[0], 'y' => $rate[1]]) ?></p>    
                            
                            <p><?php ee('Several headers will be sent alongside the response and these can be examined to determine various information about the request.') ?></p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mt-7">
                            <pre class="code bg-secondary rounded p-3">X-RateLimit-Limit: <?php echo $rate[0] ?><br>X-RateLimit-Remaining: <?php echo $rate[0]-1 ?><br>X-RateLimit-Reset: TIMESTAMP</pre>    
                        </div>                                
                    </div>
                </div>
                <div id="responsehandling" class="row mb-5">
                    <div class="col-lg-7">
                        <div class="card-header py-4">
                            <h6 class="mb-0" id="response"><i data-feather="terminal" class="mr-3"></i><?php ee('Response Handling') ?></h6>
                        </div>
                        <div class="card-body">
                            <p><?php ee('All API response are returned in JSON format by default. To convert this into usable data, the appropriate function will need to be used according to the language. In PHP, the function json_decode() can be used to convert the data to either an object (default) or an array (set the second parameter to true). It is very important to check the error key as that provides information on whether there was an error or not. You can also check the header code.') ?></p>                            
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mt-7">
                            <pre class="code bg-secondary rounded p-3"><code class="rounded json"><?php echo str_replace("                  ","", '{
                                        "error": 1,
                                        "message": "An error ocurred"
                                    }') ?></code></pre> 
                        </div>
                    </div>
                </div>                
                <?php foreach($api as $id => $el): ?>
                    <hr id="<?php echo $id ?>">
                    <h4 class="mb-5 px-4"><a href="#<?php echo $id ?>"><i data-feather="bookmark" class="mr-3"></i></a>  <?php echo $el['title'] ?></h4>   
                    <?php if($el['description']):?><p class="mt-2 ml-4"><?php echo $el['description'] ?></p><?php endif ?>
                    <?php foreach($el['endpoints'] as $key => $data): ?>
                        <div id="<?php echo $id.'-'.$key ?>" class="row mb-5">
                            <div class="col-md-7">                                                 
                                <div class="card-header">
                                    <h6 class="mb-0" id="<?php echo \Core\Helper::slug($data['title']) ?>"><i data-feather="terminal" class="mr-3"></i><?php echo $data['title'] ?></h6>
                                </div>
                                <div class="card-body">
                                    <span class="badge badge-<?php echo \Helpers\App::apiMethodColor($data['method']) ?> mr-2 align-middle text-xs"><?php echo $data['method'] ?></span> <code><?php echo $data['route'] ?></code>
                                    <p class="mt-3"><?php echo $data['description'] ?></p>    
                                    <?php if($data['parameters']): ?>
                                        <div class="table-responsive mt-4">
                                            <table class="table">
                                                <thead><tr><th><strong><?php ee("Parameter") ?></strong></th><th><strong><?php ee("Description") ?></strong></th></tr></thead>
                                                <tbody>    
                                                <?php foreach($data['parameters'] as $param => $desc): ?>
                                                <tr>
                                                    <td><?php echo $param ?></td>
                                                    <td><?php echo $desc ?></td>
                                                </tr>   
                                                <?php endforeach ?>                                                                                                        
                                                </tbody>
                                            </table>                   
                                        </div>                                         
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mt-3 p-3 bg-secondary rounded">
                                    <div class="btn-group code-lang mb-3">
                                        <a href="#curl" class="btn btn-dark btn-xs active">cURL</a>
                                        <a href="#php" class="btn btn-dark btn-xs">PHP</a>
                                    </div>
                                    <div class="code-selector" data-id="curl">
                                        <pre><code class="rounded bash"><?php echo str_replace("                                        ","", "curl --location --request ".$data['method']." '".$data['route']."' \
                                        --header 'Authorization: Bearer {$token}' \
                                        --header 'Content-Type: application/json' \
                                        ".(
                                            $data['code'] ? '--data-raw \''.json_encode($data['code'], JSON_PRETTY_PRINT) .'\'' : ''
                                        )."") ?></code></pre>                
                                    </div>
                                    <div class="code-selector" data-id="php">
                                        <pre><code class="rounded php"><?php echo str_replace("                                            ","", '$curl = curl_init();

                                            curl_setopt_array($curl, array(
                                                CURLOPT_URL => "'.$data['route'].'",
                                                CURLOPT_RETURNTRANSFER => true,
                                                CURLOPT_ENCODING => "",
                                                CURLOPT_MAXREDIRS => 2,
                                                CURLOPT_TIMEOUT => 10,
                                                CURLOPT_FOLLOWLOCATION => true,
                                                CURLOPT_CUSTOMREQUEST => "'.$data['method'].'",
                                                CURLOPT_HTTPHEADER => array(
                                                    "Authorization: Bearer '.$token.'",
                                                    "Content-Type: application/json",
                                                ),
                                                '.(
                                                    $data['code'] ? 'CURLOPT_POSTFIELDS => \''.json_encode($data['code'], JSON_PRETTY_PRINT) .'\',' : ''
                                                ).'
                                            ));

                                            $response = curl_exec($curl);

                                            curl_close($curl);
                                            echo $response;') ?></code></pre>                
                                    </div>                                 
                                </div>
                                <h6 class="my-3"><?php ee("Server response") ?></h6>
                                <div class="p-3 bg-secondary rounded">
                                    <pre><code class="rounded json"><?php echo json_encode($data['response'], JSON_PRETTY_PRINT) ?></code></pre>
                                </div> 
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>