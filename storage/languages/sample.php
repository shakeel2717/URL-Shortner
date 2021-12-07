<?php
/**
 * English language for the frontend
 */
return [
    /**
     * Language Information
     */
    "code" => "en",
    "region" => "en_US",
    "name" => "Sample",
    "author" => "GemPixel",
    "date" => "17/05/2020",
    /**
     * Language Data
     */
    "data" => [
        #: app/config/api.php:25
        "Account" => "",
        #: app/config/api.php:29
        "Get Account" => "",
        #: app/config/api.php:32
        "To get information on the account, you can send a request to this endpoint and it will return data on the account." => "",
        #: app/config/api.php:49
        "Update Account" => "",
        #: app/config/api.php:52
        "To update information on the account, you can send a request to this endpoint and it will update data on the account." => "",
        #: app/config/api.php:66 app/controllers/user/DashboardController.php:98
        #: app/controllers/user/StatsController.php:70
        #: storage/themes/default/bio/edit.php:47
        #: storage/themes/default/bio/edit.php:60
        #: storage/themes/default/bio/edit.php:247
        #: storage/themes/default/bio/edit.php:298
        #: storage/themes/default/bio/new.php:44 storage/themes/default/bio/new.php:57
        #: storage/themes/default/bio/new.php:233
        #: storage/themes/default/bio/new.php:284 storage/themes/default/index.php:570
        #: storage/themes/default/partials/sidebar_menu.php:29
        #: storage/themes/default/teams/edit.php:13
        #: storage/themes/default/teams/index.php:115
        #: storage/themes/default/user/campaigns.php:23
        #: storage/themes/default/user/index.php:8
        #: storage/themes/default/user/stats.php:14
        "Links" => "",
        #: app/config/api.php:70
        "List all Links" => "",
        #: app/config/api.php:73
        "To get your links via the API, you can use this endpoint. You can also filter data (See table for more info)." => "",
        #: app/config/api.php:114
        "Get a single link" => "",
        #: app/config/api.php:117
        "To get details for a single link via the API, you can use this endpoint." => "",
        #: app/config/api.php:155
        "Shorten a Link" => "",
        #: app/config/api.php:158
        "To shorten a link, you need to send a valid data in JSON via a POST request. The data must be sent as the raw body of your request as shown below. The example below shows all the parameters you can send but you are not required to send all (See table for more info)." => "",
        #: app/config/api.php:213
        "Update a Link" => "",
        #: app/config/api.php:216
        "To update a link, you need to send a valid data in JSON via a PUT request. The data must be sent as the raw body of your request as shown below. The example below shows all the parameters you can send but you are not required to send all (See table for more info)." => "",
        #: app/config/api.php:271
        "Delete a Link" => "",
        #: app/config/api.php:274
        "To delete a link, you need to send a DELETE request." => "",
        #: app/config/api.php:285 app/controllers/PageController.php:288
        #: app/controllers/user/QRController.php:69
        #: storage/themes/default/pages/qr.php:6
        #: storage/themes/default/partials/footer.php:45
        #: storage/themes/default/partials/main_menu.php:58
        #: storage/themes/default/partials/sidebar_menu.php:17
        #: storage/themes/default/pricing/index.php:50
        #: storage/themes/default/qr/index.php:3
        #: storage/themes/default/qr/index.php:54
        #: storage/themes/default/teams/edit.php:19
        #: storage/themes/default/teams/index.php:121
        #: storage/themes/default/user/billing.php:78
        "QR Codes" => "",
        #: app/config/api.php:289
        "List all QR codes" => "",
        #: app/config/api.php:292
        "To get your QR codes via the API, you can use this endpoint. You can also filter data (See table for more info)." => "",
        #: app/config/api.php:326
        "Get a single QR Code" => "",
        #: app/config/api.php:329
        "To get details for a single QR code via the API, you can use this endpoint." => "",
        #: app/config/api.php:365
        "Create a QR Code" => "",
        #: app/config/api.php:368
        "To shorten a QR Code, you need to send a valid data in JSON via a POST request. The data must be sent as the raw body of your request as shown below. The example below shows all the parameters you can send but you are not required to send all (See table for more info)." => "",
        #: app/config/api.php:390
        "Update a QR Code" => "",
        #: app/config/api.php:393
        "To update a QR Code, you need to send a valid data in JSON via a PUT request. The data must be sent as the raw body of your request as shown below. The example below shows all the parameters you can send but you are not required to send all (See table for more info)." => "",
        #: app/config/api.php:413
        "Delete a QR Code" => "",
        #: app/config/api.php:416
        "To delete a QR code, you need to send a DELETE request." => "",
        #: app/config/api.php:427
        "Plans" => "",
        #: app/config/api.php:428 app/config/api.php:585
        "This endpoint is only accessible by users with admin privileges." => "",
        #: app/config/api.php:431
        "List all plans" => "",
        #: app/config/api.php:434
        "Get a list of all plans on the platform." => "",
        #: app/config/api.php:564
        "Subscribe a user to a plan" => "",
        #: app/config/api.php:567
        "To subscribe a user to plan, send a PUT request to this endpoint with the plan id and user id. The type of subscription and the expiration date will need to be specified. If the expiration date is not specified, the date will be adjusted according to the type." => "",
        #: app/config/api.php:570
        "(optional) Expiration date of the plan e.g. " => "",
        #: app/config/api.php:584
        "Users" => "",
        #: app/config/api.php:588
        "List all users" => "",
        #: app/config/api.php:591
        "Get a list of all users on the platform. Data can be filtered by sending a filter parameter in the url." => "",
        #: app/config/api.php:623
        "Create a user" => "",
        #: app/config/api.php:626
        "To create a user, use this endpoint and send the following information as JSON." => "",
        #: app/config/api.php:652
        "Delete a user" => "",
        #: app/config/api.php:655
        "To delete a user, use this endpoint." => "",
        #: app/controllers/BlogController.php:54 storage/themes/default/blog.php:6
        #: storage/themes/default/partials/main_menu.php:88
        "Blog" => "",
        #: app/controllers/LinkController.php:138
        "The password is invalid or does not match." => "",
        #: app/controllers/LinkController.php:405
        #: app/controllers/LinkController.php:429
        #: app/controllers/LinkController.php:452
        #: app/controllers/LinkController.php:481
        #: app/controllers/LinkController.php:508
        #: app/controllers/LinkController.php:537
        #: app/controllers/LinkController.php:565
        #: app/controllers/LinkController.php:609
        #: app/controllers/user/CampaignsController.php:78
        #: app/controllers/user/CampaignsController.php:122
        #: app/controllers/user/OverlayController.php:76
        #: app/controllers/user/OverlayController.php:107
        #: app/controllers/user/OverlayController.php:134
        #: app/controllers/user/OverlayController.php:162
        #: app/controllers/user/OverlayController.php:1623
        #: app/controllers/user/SplashController.php:74
        #: app/controllers/user/SplashController.php:100
        #: app/controllers/user/SplashController.php:176
        #: app/controllers/user/SplashController.php:202
        #: app/controllers/user/SplashController.php:282
        #: app/controllers/user/TeamsController.php:75
        "You do not have this permission. Please contact your team administrator." => "",
        #: app/controllers/LinkController.php:409
        #: app/controllers/user/AccountController.php:425
        #: app/controllers/user/AccountController.php:448
        #: app/controllers/user/BioController.php:250
        #: app/controllers/user/CampaignsController.php:169
        #: app/controllers/user/DomainsController.php:174
        #: app/controllers/user/OverlayController.php:120
        #: app/controllers/user/OverlayController.php:147
        #: app/controllers/user/OverlayController.php:177
        #: app/controllers/user/OverlayController.php:1627
        #: app/controllers/user/PixelsController.php:221
        #: app/controllers/user/QRController.php:421
        #: app/controllers/user/TeamsController.php:172
        "An unexpected error occurred. Please try again." => "",
        #: app/controllers/LinkController.php:413
        "Link not found. Please try again." => "",
        #: app/controllers/LinkController.php:416
        "Link has been deleted." => "",
        #: app/controllers/LinkController.php:434
        "No link was selected. Please try again." => "",
        #: app/controllers/LinkController.php:440
        "Selected Links have been deleted." => "",
        #: app/controllers/LinkController.php:460
        #: app/controllers/LinkController.php:489
        #: app/controllers/LinkController.php:516
        #: app/controllers/LinkController.php:545
        #: app/controllers/LinkController.php:641
        "You need to select at least 1 link." => "",
        #: app/controllers/LinkController.php:468
        "Selected links have been archived." => "",
        #: app/controllers/LinkController.php:496
        "Selected links have been removed from archive." => "",
        #: app/controllers/LinkController.php:524
        "Selected links have been set to public." => "",
        #: app/controllers/LinkController.php:552
        "Selected links have been set to private." => "",
        #: app/controllers/LinkController.php:568
        #: app/controllers/user/ExportController.php:73
        "Link does not exist." => "",
        #: app/controllers/LinkController.php:570
        #: storage/themes/default/user/edit.php:3
        #: storage/themes/default/user/edit.php:231
        "Update Link" => "",
        #: app/controllers/LinkController.php:612
        "URL does not exist." => "",
        #: app/controllers/LinkController.php:620
        "Link has been updated successfully." => "",
        #: app/controllers/LinkController.php:632
        #: app/controllers/LinkController.php:635
        "Invalid campaign. Please choose a valid campaign." => "",
        #: app/controllers/LinkController.php:648
        "Selected links have been added to the " => "",
        #: app/controllers/LinkController.php:730
        "This has been disabled in demo." => "",
        #: app/controllers/PageController.php:72
        #: storage/themes/default/pages/contact.php:6
        #: storage/themes/default/partials/footer.php:66
        "Contact Us" => "",
        #: app/controllers/PageController.php:92
        #: app/controllers/PageController.php:156
        #: app/controllers/UsersController.php:261
        #: app/controllers/UsersController.php:343
        #: app/controllers/user/AccountController.php:314
        #: app/controllers/user/OverlayController.php:300
        #: app/controllers/user/OverlayController.php:460
        #: storage/themes/default/auth/register.php:30
        #: storage/themes/default/pages/contact.php:26
        #: storage/themes/default/pages/report.php:22
        "Please enter a valid email." => "",
        #: app/controllers/PageController.php:121
        "Your message has been sent. We will reply you as soon as possible." => "",
        #: app/controllers/PageController.php:137
        "Report Link" => "",
        #: app/controllers/PageController.php:164
        #: storage/themes/default/pages/report.php:26
        "Please enter a valid link." => "",
        #: app/controllers/PageController.php:196
        "Thank you. We will review this link and take action." => "",
        #: app/controllers/PageController.php:217
        #: storage/themes/default/pages/affiliate.php:22
        #: storage/themes/default/pages/faq.php:6
        #: storage/themes/default/pricing/index.php:85
        "Frequently Asked Questions" => "",
        #: app/controllers/PageController.php:234
        #: storage/themes/default/pages/api.php:49
        "API Reference for Developers" => "",
        #: app/controllers/PageController.php:275
        #: storage/themes/default/partials/footer.php:63
        "Affiliate Program" => "",
        #: app/controllers/PageController.php:290
        #: storage/themes/default/pages/qr.php:9
        "Easy to use, dynamic and customizable QR codes for your marketing campaigns. Analyze statistics and optimize your marketing strategy and increase engagement." => "",
        #: app/controllers/PageController.php:303
        #: storage/themes/default/pages/bio.php:6
        #: storage/themes/default/partials/footer.php:46
        #: storage/themes/default/partials/main_menu.php:66
        #: storage/themes/default/pricing/index.php:49
        #: storage/themes/default/user/billing.php:77
        "Bio Profiles" => "",
        #: app/controllers/PageController.php:305
        #: storage/themes/default/pages/bio.php:9
        "Convert your followers by creating beautiful pages that group all of your important links on the single page." => "",
        #: app/controllers/StatsController.php:62
        #: app/controllers/StatsController.php:67
        #: app/controllers/StatsController.php:233
        #: app/controllers/StatsController.php:238
        #: app/controllers/StatsController.php:453
        #: app/controllers/StatsController.php:458
        #: app/controllers/StatsController.php:601
        #: app/controllers/StatsController.php:606
        #: app/controllers/StatsController.php:747
        #: app/controllers/StatsController.php:752
        #: app/controllers/StatsController.php:894
        #: app/controllers/StatsController.php:899
        "This link is private and only the creator can access the stats. If you are the creator, please login to access it." => "",
        #: app/controllers/StatsController.php:90
        #: app/controllers/StatsController.php:259
        #: app/controllers/StatsController.php:479
        #: app/controllers/StatsController.php:627
        #: app/controllers/StatsController.php:773
        #: app/controllers/StatsController.php:920 app/helpers/App.php:683
        #: storage/themes/default/user/settings.php:84
        "Direct" => "",
        #: app/controllers/StatsController.php:94
        #: app/controllers/StatsController.php:99
        #: app/controllers/StatsController.php:104
        #: app/controllers/StatsController.php:266
        #: app/controllers/StatsController.php:486
        #: app/controllers/StatsController.php:634
        #: app/controllers/StatsController.php:780
        #: app/controllers/StatsController.php:942
        "Stats for" => "",
        #: app/controllers/StatsController.php:105
        "Advanced statistics page for the short URL" => "",
        #: app/controllers/StatsController.php:122
        #: app/controllers/StatsController.php:289
        #: app/controllers/StatsController.php:507
        #: app/controllers/StatsController.php:652
        #: app/controllers/StatsController.php:798
        #: app/controllers/user/CampaignsController.php:202
        #: app/controllers/user/StatsController.php:51
        "Last 7 Days" => "",
        #: app/controllers/StatsController.php:123
        #: app/controllers/StatsController.php:290
        #: app/controllers/StatsController.php:508
        #: app/controllers/StatsController.php:653
        #: app/controllers/StatsController.php:799
        #: app/controllers/user/CampaignsController.php:203
        #: app/controllers/user/StatsController.php:52
        "Last 30 Days" => "",
        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:291
        #: app/controllers/StatsController.php:509
        #: app/controllers/StatsController.php:654
        #: app/controllers/StatsController.php:800
        #: app/controllers/user/CampaignsController.php:204
        #: app/controllers/user/StatsController.php:53
        "This Month" => "",
        #: app/controllers/StatsController.php:125
        #: app/controllers/StatsController.php:292
        #: app/controllers/StatsController.php:510
        #: app/controllers/StatsController.php:655
        #: app/controllers/StatsController.php:801
        #: app/controllers/user/CampaignsController.php:205
        #: app/controllers/user/StatsController.php:54
        "Last Month" => "",
        #: app/controllers/StatsController.php:126
        #: app/controllers/StatsController.php:293
        #: app/controllers/StatsController.php:511
        #: app/controllers/StatsController.php:656
        #: app/controllers/StatsController.php:802
        #: app/controllers/user/CampaignsController.php:206
        #: app/controllers/user/StatsController.php:55
        "Last 3 Months" => "",
        #: app/controllers/StatsController.php:157
        #: app/controllers/StatsController.php:431
        #: app/controllers/user/CampaignsController.php:241
        #: app/controllers/user/DashboardController.php:201
        #: app/controllers/user/StatsController.php:101
        #: storage/themes/default/index.php:580
        #: storage/themes/default/partials/links.php:71
        #: storage/themes/default/stats/index.php:18
        #: storage/themes/default/stats/partial.php:32
        #: storage/themes/default/user/campaignstats.php:37
        #: storage/themes/default/user/index.php:18
        #: storage/themes/default/user/stats.php:24
        "Clicks" => "",
        #: app/controllers/StatsController.php:262
        #: app/controllers/StatsController.php:269
        "Country Stats for" => "",
        #: app/controllers/StatsController.php:272
        #: app/controllers/StatsController.php:948
        "Country statistics page for the short URL" => "",
        #: app/controllers/StatsController.php:368
        #: app/controllers/StatsController.php:869
        #: storage/themes/default/stats/partial.php:47
        #: storage/themes/default/stats/partial.php:55
        "Unknown" => "",
        #: app/controllers/StatsController.php:427
        #: storage/themes/default/stats/index.php:44
        #: storage/themes/default/user/index.php:140
        "Somewhere from" => "",
        #: app/controllers/StatsController.php:482
        #: app/controllers/StatsController.php:489
        "Platform Stats for" => "",
        #: app/controllers/StatsController.php:491
        "Platform statistics page for the short URL" => "",
        #: app/controllers/StatsController.php:630
        #: app/controllers/StatsController.php:637
        "Browser Stats for" => "",
        #: app/controllers/StatsController.php:639
        "Browser statistics page for the short URL" => "",
        #: app/controllers/StatsController.php:776
        #: app/controllers/StatsController.php:783
        "Language Stats for" => "",
        #: app/controllers/StatsController.php:785
        "Language statistics page for the short URL" => "",
        #: app/controllers/StatsController.php:938
        #: app/controllers/StatsController.php:945
        "Referrers Stats for" => "",
        #: app/controllers/SubscriptionController.php:70
        #: app/controllers/SubscriptionController.php:114
        "Current" => "",
        #: app/controllers/SubscriptionController.php:73
        #: app/controllers/SubscriptionController.php:77
        #: app/controllers/SubscriptionController.php:117
        #: app/controllers/SubscriptionController.php:121
        "{d}-Day Free Trial" => "",
        #: app/controllers/SubscriptionController.php:73
        #: app/controllers/SubscriptionController.php:117
        #: storage/themes/default/partials/topbar_menu.php:9
        #: storage/themes/default/user/billing.php:91
        "Upgrade" => "",
        #: app/controllers/SubscriptionController.php:77
        #: app/controllers/SubscriptionController.php:121
        #: storage/themes/default/index.php:117 storage/themes/default/index.php:405
        #: storage/themes/default/pages/bio.php:12
        #: storage/themes/default/pages/bio.php:46
        #: storage/themes/default/pages/bio.php:64
        #: storage/themes/default/pages/qr.php:12
        #: storage/themes/default/pages/qr.php:29
        #: storage/themes/default/pages/qr.php:47
        #: storage/themes/default/partials/footer.php:15
        #: storage/themes/default/partials/main_menu.php:112
        #: storage/themes/default/partials/main_menu.php:129
        "Get Started" => "",
        #: app/controllers/SubscriptionController.php:133
        "Premium Plan Pricing" => "",
        #: app/controllers/SubscriptionController.php:165
        #: app/helpers/payments/Stripe.php:403
        "You have been successfully subscribed." => "",
        #: app/controllers/SubscriptionController.php:171
        "You have already used a trial." => "",
        #: app/controllers/SubscriptionController.php:198
        "You already subscribed to this plan. If you want to upgrade, please choose another plan." => "",
        #: app/controllers/SubscriptionController.php:270
        "Promo code has expired. Please try again." => "",
        #: app/controllers/SubscriptionController.php:273
        #: app/controllers/SubscriptionController.php:285
        "Please enter a valid promo code." => "",
        #: app/controllers/UsersController.php:50
        #: storage/themes/default/gates/domain.php:14
        "Login to your account" => "",
        #: app/controllers/UsersController.php:67
        "You have been blocked for 1 hour due to many unsuccessful login attempts." => "",
        #: app/controllers/UsersController.php:70
        "Please enter a valid email or username." => "",
        #: app/controllers/UsersController.php:72
        #: app/controllers/UsersController.php:80
        #: app/controllers/UsersController.php:157
        "Wrong email and password combination." => "",
        #: app/controllers/UsersController.php:95
        #: app/controllers/UsersController.php:594
        #: app/controllers/UsersController.php:668
        #: app/controllers/UsersController.php:783
        "You have been banned due to abuse. Please contact us for clarification." => "",
        #: app/controllers/UsersController.php:99
        #: app/controllers/UsersController.php:598
        #: app/controllers/UsersController.php:672
        #: app/controllers/UsersController.php:787
        "You haven't activated your account. Please check your email for the activation link. If you haven't received any emails from us, please contact us." => "",
        #: app/controllers/UsersController.php:121
        "Please enter the 2FA access code to login." => "",
        #: app/controllers/UsersController.php:144
        #: app/controllers/UsersController.php:217
        #: app/controllers/UsersController.php:312
        #: app/controllers/UsersController.php:315
        "You have been successfully registered." => "",
        #: app/controllers/UsersController.php:170
        #: storage/themes/default/auth/2fa.php:14
        "Enter your 2FA access code" => "",
        #: app/controllers/UsersController.php:191
        #: app/controllers/UsersController.php:196
        #: app/controllers/UsersController.php:200
        "Invalid token. Please try again." => "",
        #: app/controllers/UsersController.php:232
        #: app/controllers/UsersController.php:252
        "We are not accepting users at this time." => "",
        #: app/controllers/UsersController.php:234
        "Register and manage your urls" => "",
        #: app/controllers/UsersController.php:235
        "Register an account and gain control over your urls. Manage them, edit them or remove them without hassle." => "",
        #: app/controllers/UsersController.php:257
        "The email, the username and the password are required." => "",
        #: app/controllers/UsersController.php:263
        #: app/controllers/user/AccountController.php:319
        "An account is already associated with this email." => "",
        #: app/controllers/UsersController.php:267
        #: app/controllers/UsersController.php:489
        #: app/controllers/user/AccountController.php:332
        "Please enter a valid username." => "",
        #: app/controllers/UsersController.php:268
        #: app/controllers/UsersController.php:491
        "Username already exists." => "",
        #: app/controllers/UsersController.php:272
        #: app/controllers/UsersController.php:495
        "This username cannot be used or already exists. Please choose another username" => "",
        #: app/controllers/UsersController.php:274
        #: app/controllers/UsersController.php:412
        #: app/controllers/UsersController.php:497
        "Password must be at least 5 characters." => "",
        #: app/controllers/UsersController.php:276
        #: app/controllers/UsersController.php:414
        #: app/controllers/UsersController.php:499
        #: app/controllers/user/AccountController.php:346
        "Passwords don't match." => "",
        #: app/controllers/UsersController.php:278
        #: app/controllers/UsersController.php:501
        "You must agree to our terms of service." => "",
        #: app/controllers/UsersController.php:304
        "An email has been sent to activate your account. Please check your spam folder if you didn't receive it." => "",
        #: app/controllers/UsersController.php:327
        #: app/controllers/UsersController.php:382
        #: storage/themes/default/auth/forgot.php:14
        #: storage/themes/default/auth/forgot.php:32
        #: storage/themes/default/auth/reset.php:14
        #: storage/themes/default/auth/reset.php:39
        "Reset Password" => "",
        #: app/controllers/UsersController.php:328
        #: storage/themes/default/auth/forgot.php:15
        "If you forgot your password, you can request a link to reset your password." => "",
        #: app/controllers/UsersController.php:353
        "If an active account is associated with this email, you should receive an email shortly." => "",
        #: app/controllers/UsersController.php:368
        #: app/controllers/UsersController.php:375
        #: app/controllers/UsersController.php:379
        #: app/controllers/UsersController.php:398
        #: app/controllers/UsersController.php:405
        #: app/controllers/UsersController.php:409
        #: app/controllers/UsersController.php:442
        "Token has expired, please request another link." => "",
        #: app/controllers/UsersController.php:417
        "Your new password cannot be the same as the old password." => "",
        #: app/controllers/UsersController.php:428
        "Your password has been changed." => "",
        #: app/controllers/UsersController.php:451
        "Your email has been successfully verified." => "",
        #: app/controllers/UsersController.php:465
        #: app/controllers/UsersController.php:486
        "The invitation link has expired or is currently unavailable. Please contact administrator." => "",
        #: app/controllers/UsersController.php:468
        #: storage/themes/default/auth/invite.php:14
        "Join Team" => "",
        #: app/controllers/UsersController.php:511
        "Your account has been successfully activated." => "",
        #: app/controllers/UsersController.php:522
        "You have been successfully logged out." => "",
        #: app/controllers/UsersController.php:535
        "Sorry, Facebook connect is not available right now." => "",
        #: app/controllers/UsersController.php:537
        "You must grant access to this application to use your facebook account." => "",
        #: app/controllers/UsersController.php:554
        #: app/controllers/UsersController.php:559
        "An error has occurred. Please try again later." => "",
        #: app/controllers/UsersController.php:569
        "You must grant permission to this application to use your profile information." => "",
        #: app/controllers/UsersController.php:573
        #: app/controllers/UsersController.php:653
        #: app/controllers/UsersController.php:768
        "The email linked to your account has been already used. If you have used that, please login to your existing account otherwise please contact us." => "",
        #: app/controllers/UsersController.php:621
        #: app/controllers/UsersController.php:701
        #: app/controllers/UsersController.php:817
        "Welcome! You have been successfully logged in." => "",
        #: app/controllers/UsersController.php:632
        #: app/controllers/UsersController.php:714
        "Sorry, Twitter connect is not available right now." => "",
        #: app/controllers/UsersController.php:635
        "You must grant permission to this application to use your twitter account." => "",
        #: app/controllers/UsersController.php:650
        "And error occurred, please try again later." => "",
        #: app/controllers/UsersController.php:731
        "An error has occurred! Please make sure that you have set up this application as instructed." => "",
        #: app/controllers/UsersController.php:744
        #: app/controllers/UsersController.php:759
        "Sorry, Google connect is not available right now." => "",
        #: app/controllers/UsersController.php:765
        "You must grant permission to this application to use your Google account." => "",
        #: app/controllers/api/LinksController.php:177
        #: app/controllers/api/QRController.php:178
        "Direct, email and other" => "",
        #: app/controllers/user/AccountController.php:51
        #: storage/themes/default/partials/topbar_menu.php:58
        #: storage/themes/default/user/billing.php:1
        "Billing" => "",
        #: app/controllers/user/AccountController.php:68
        "Wow there. You are an admin. You can't cancel your membership." => "",
        #: app/controllers/user/AccountController.php:72 app/helpers/Slack.php:105
        "Something went wrong, please try again." => "",
        #: app/controllers/user/AccountController.php:76
        #: app/controllers/user/AccountController.php:82
        #: app/controllers/user/AccountController.php:179
        #: app/controllers/user/AccountController.php:185
        "Your password is incorrect." => "",
        #: app/controllers/user/AccountController.php:90
        "Your trial has been canceled." => "",
        #: app/controllers/user/AccountController.php:124
        "Your subscription has been canceled." => "",
        #: app/controllers/user/AccountController.php:140
        "Payment not found. Please try again." => "",
        #: app/controllers/user/AccountController.php:154
        #: storage/themes/default/user/billing.php:57
        "View Invoice" => "",
        #: app/controllers/user/AccountController.php:175
        "As an admin, you cannot delete your account form this page." => "",
        #: app/controllers/user/AccountController.php:233
        "Your account has been deleted successfully and your data has been wiped out. If you have any questions please don't hesitate to contact us." => "",
        #: app/controllers/user/AccountController.php:237
        "Your account has been terminated." => "",
        #: app/controllers/user/AccountController.php:260
        "Your account has been successfully terminated." => "",
        #: app/controllers/user/AccountController.php:295
        #: storage/themes/default/partials/topbar_menu.php:62
        #: storage/themes/default/user/settings.php:1
        "Settings" => "",
        #: app/controllers/user/AccountController.php:334
        "This username has already been used. Please try again." => "",
        #: app/controllers/user/AccountController.php:344
        "Password must contain at least 5 characters." => "",
        #: app/controllers/user/AccountController.php:350
        "Passwords is the same as the old password." => "",
        #: app/controllers/user/AccountController.php:362
        #: app/controllers/user/AccountController.php:364
        #: app/controllers/user/BioController.php:174
        #: app/controllers/user/BioController.php:410
        "Avatar must be either a PNG or a JPEG (Max 500kb)." => "",
        #: app/controllers/user/AccountController.php:368
        #: app/controllers/user/SplashController.php:131
        #: app/controllers/user/SplashController.php:233
        "Avatar must be either a PNG or a JPEG with a recommended dimension of 200x200." => "",
        #: app/controllers/user/AccountController.php:400
        #: app/controllers/user/AccountController.php:409
        "Account has been successfully updated." => "",
        #: app/controllers/user/AccountController.php:400
        "You have changed your email. Please check your email before logging out and activate your account." => "",
        #: app/controllers/user/AccountController.php:436
        "2FA has been activated on your account. Please make sure to backup the secret key or the QR code." => "",
        #: app/controllers/user/AccountController.php:445
        "2FA has been disabled on your account." => "",
        #: app/controllers/user/AccountController.php:467
        "API key has been regenerated successfully. Please do not forget to update your application." => "",
        #: app/controllers/user/BioController.php:76
        "Import" => "",
        #: app/controllers/user/BioController.php:76
        "We have detected that you have an old bio page. Do you want to import it?<br><br><a href=\\\"?importoldbio=true\\\" class=\\\"btn btn-primary\\\">" => "",
        #: app/controllers/user/BioController.php:79
        #: storage/themes/default/bio/index.php:62
        #: storage/themes/default/partials/sidebar_menu.php:10
        #: storage/themes/default/teams/edit.php:26
        #: storage/themes/default/teams/index.php:128
        "Bio Pages" => "",
        #: app/controllers/user/BioController.php:107
        #: storage/themes/default/bio/index.php:7
        #: storage/themes/default/bio/index.php:54
        #: storage/themes/default/bio/new.php:1
        #: storage/themes/default/teams/edit.php:27
        #: storage/themes/default/teams/index.php:129
        "Create Bio" => "",
        #: app/controllers/user/BioController.php:144
        #: app/controllers/user/BioController.php:334
        "Please enter a name for your profile." => "",
        #: app/controllers/user/BioController.php:149
        #: app/controllers/user/BioController.php:339
        "Please add at least one link." => "",
        #: app/controllers/user/BioController.php:192
        #: app/controllers/user/BioController.php:384 app/traits/Links.php:133
        #: app/traits/Links.php:453
        "Custom alias must be at least 3 characters." => "",
        #: app/controllers/user/BioController.php:195
        #: app/controllers/user/BioController.php:387 app/traits/Links.php:136
        #: app/traits/Links.php:456
        "Inappropriate aliases are not allowed." => "",
        #: app/controllers/user/BioController.php:198
        #: app/controllers/user/BioController.php:201
        #: app/controllers/user/BioController.php:390
        #: app/controllers/user/BioController.php:393 app/traits/Links.php:139
        #: app/traits/Links.php:142 app/traits/Links.php:459 app/traits/Links.php:462
        "That alias is taken. Please choose another one." => "",
        #: app/controllers/user/BioController.php:204
        #: app/controllers/user/BioController.php:396 app/traits/Links.php:145
        #: app/traits/Links.php:465
        "That alias is reserved. Please choose another one." => "",
        #: app/controllers/user/BioController.php:207
        #: app/controllers/user/BioController.php:399 app/traits/Links.php:148
        #: app/traits/Links.php:468
        "That is a premium alias and is reserved to only pro members." => "",
        #: app/controllers/user/BioController.php:236
        "Profile has been successfully created." => "",
        #: app/controllers/user/BioController.php:254
        #: app/controllers/user/BioController.php:275
        #: app/controllers/user/BioController.php:329
        #: app/controllers/user/BioController.php:443
        "Profile does not exist." => "",
        #: app/controllers/user/BioController.php:262
        "Profile has been successfully deleted." => "",
        #: app/controllers/user/BioController.php:287
        #: storage/themes/default/bio/edit.php:3
        "Update Bio" => "",
        #: app/controllers/user/BioController.php:428
        "Profile has been successfully updated." => "",
        #: app/controllers/user/BioController.php:450
        "Profile has been set as default and can now be access via your profile page." => "",
        #: app/controllers/user/BioController.php:452
        "Profile has been set as default and can now be access via your profile page. Your profile setting is currently set on private." => "",
        #: app/controllers/user/CampaignsController.php:58
        #: storage/themes/default/partials/sidebar_menu.php:45
        #: storage/themes/default/teams/edit.php:60
        #: storage/themes/default/teams/index.php:162
        #: storage/themes/default/user/campaigns.php:3
        #: storage/themes/default/user/index.php:240
        #: storage/themes/default/user/links.php:146
        "Campaigns" => "",
        #: app/controllers/user/CampaignsController.php:82
        #: app/controllers/user/CampaignsController.php:130
        "Campaign name cannot be empty and must have at least 2 characters." => "",
        #: app/controllers/user/CampaignsController.php:86
        #: app/controllers/user/CampaignsController.php:134
        "You already have a campaign with that name." => "",
        #: app/controllers/user/CampaignsController.php:94
        #: app/controllers/user/CampaignsController.php:145
        "This slug is currently not available. Please choose another one." => "",
        #: app/controllers/user/CampaignsController.php:107
        "Campaign was successfully created. You may start adding links to it now." => "",
        #: app/controllers/user/CampaignsController.php:126
        "Campaign does not exist" => "",
        #: app/controllers/user/CampaignsController.php:153
        "Campaign was updated successfully." => "",
        #: app/controllers/user/CampaignsController.php:173
        #: app/controllers/user/CampaignsController.php:190
        "Campaign not found. Please try again." => "",
        #: app/controllers/user/CampaignsController.php:178
        "Campaign has been deleted." => "",
        #: app/controllers/user/CampaignsController.php:219
        #: storage/themes/default/user/campaignstats.php:3
        "Campaign Statistics" => "",
        #: app/controllers/user/DashboardController.php:78
        #: storage/themes/default/partials/main_menu.php:107
        #: storage/themes/default/partials/main_menu.php:121
        #: storage/themes/default/partials/sidebar_menu.php:4
        "Dashboard" => "",
        #: app/controllers/user/DashboardController.php:104
        "Campaign Links" => "",
        #: app/controllers/user/DashboardController.php:160
        #: storage/themes/default/partials/sidebar_menu.php:34
        "Archived Links" => "",
        #: app/controllers/user/DashboardController.php:184
        #: storage/themes/default/partials/sidebar_menu.php:39
        "Expired Links" => "",
        #: app/controllers/user/DashboardController.php:298
        #: storage/themes/default/layouts/dashboard.php:116
        #: storage/themes/default/layouts/main.php:64
        "Keyword must be more than 3 characters!" => "",
        #: app/controllers/user/DashboardController.php:314
        "Affiliate Referrals" => "",
        #: app/controllers/user/DomainsController.php:54
        #: storage/themes/default/domains/index.php:3
        #: storage/themes/default/partials/sidebar_menu.php:73
        #: storage/themes/default/pricing/index.php:55
        #: storage/themes/default/teams/edit.php:54
        #: storage/themes/default/user/billing.php:83
        "Branded Domains" => "",
        #: app/controllers/user/DomainsController.php:73
        #: storage/themes/default/domains/new.php:1
        "New Domain" => "",
        #: app/controllers/user/DomainsController.php:96
        "A valid domain name is required." => "",
        #: app/controllers/user/DomainsController.php:100
        "The domain has been already used." => "",
        #: app/controllers/user/DomainsController.php:106
        "A valid url is required for the root domain." => "",
        #: app/controllers/user/DomainsController.php:107
        "A valid url is required for the 404 page." => "",
        #: app/controllers/user/DomainsController.php:117
        "Domain has been added successfully" => "",
        #: app/controllers/user/DomainsController.php:130
        #: app/controllers/user/DomainsController.php:151
        #: app/controllers/user/DomainsController.php:178
        "Domain not found. Please try again." => "",
        #: app/controllers/user/DomainsController.php:133
        #: storage/themes/default/domains/edit.php:1
        #: storage/themes/default/domains/index.php:40
        "Edit Domain" => "",
        #: app/controllers/user/DomainsController.php:158
        "Domain has been updated successfully." => "",
        #: app/controllers/user/DomainsController.php:183
        "Domain has been deleted." => "",
        #: app/controllers/user/ExportController.php:101
        #: app/controllers/user/ExportController.php:135
        "Please specify a range." => "",
        #: app/controllers/user/OverlayController.php:61 app/helpers/App.php:693
        #: storage/themes/default/overlay/create.php:31
        #: storage/themes/default/overlay/index.php:3
        #: storage/themes/default/overlay/index.php:54
        #: storage/themes/default/partials/sidebar_menu.php:59
        #: storage/themes/default/pricing/index.php:52
        #: storage/themes/default/teams/edit.php:40
        #: storage/themes/default/teams/index.php:142
        #: storage/themes/default/user/billing.php:80
        "CTA Overlay" => "",
        #: app/controllers/user/OverlayController.php:90
        #: storage/themes/default/overlay/create.php:3
        #: storage/themes/default/overlay/index.php:6
        #: storage/themes/default/overlay/index.php:45
        "Create a CTA Overlay" => "",
        #: app/controllers/user/OverlayController.php:138
        #: app/controllers/user/OverlayController.php:166
        "Overlay page does not exist." => "",
        #: app/controllers/user/OverlayController.php:287
        #: app/controllers/user/OverlayController.php:447
        #: storage/themes/default/overlay/create_contact.php:12
        #: storage/themes/default/overlay/create_contact.php:62
        #: storage/themes/default/overlay/create_contact.php:161
        #: storage/themes/default/overlay/create_image.php:12
        #: storage/themes/default/overlay/create_message.php:12
        #: storage/themes/default/overlay/create_newsletter.php:12
        #: storage/themes/default/overlay/create_poll.php:12
        #: storage/themes/default/overlay/edit_contact.php:12
        #: storage/themes/default/overlay/edit_image.php:12
        #: storage/themes/default/overlay/edit_message.php:12
        #: storage/themes/default/overlay/edit_newsletter.php:12
        #: storage/themes/default/overlay/edit_poll.php:12
        #: storage/themes/default/pages/contact.php:21
        #: storage/themes/default/pages/contact.php:22
        #: storage/themes/default/splash/create.php:12
        #: storage/themes/default/splash/edit.php:12
        #: storage/themes/default/user/settings.php:28
        "Name" => "",
        #: app/controllers/user/OverlayController.php:288
        #: app/controllers/user/OverlayController.php:448
        #: storage/themes/default/auth/forgot.php:22
        #: storage/themes/default/auth/invite.php:22
        #: storage/themes/default/overlay/create_contact.php:69
        #: storage/themes/default/overlay/create_contact.php:165
        #: storage/themes/default/pages/contact.php:25
        #: storage/themes/default/pages/contact.php:26
        #: storage/themes/default/pages/report.php:21
        #: storage/themes/default/pages/report.php:22
        #: storage/themes/default/qr/edit.php:43 storage/themes/default/qr/edit.php:47
        #: storage/themes/default/qr/edit.php:114 storage/themes/default/qr/new.php:22
        #: storage/themes/default/qr/new.php:61 storage/themes/default/qr/new.php:65
        #: storage/themes/default/qr/new.php:126
        #: storage/themes/default/teams/edit.php:7
        #: storage/themes/default/teams/index.php:109
        #: storage/themes/default/user/settings.php:34
        "Email" => "",
        #: app/controllers/user/OverlayController.php:289
        #: app/controllers/user/OverlayController.php:449
        #: storage/themes/default/overlay/create_contact.php:76
        #: storage/themes/default/overlay/create_contact.php:169
        #: storage/themes/default/pages/contact.php:29
        #: storage/themes/default/qr/edit.php:55 storage/themes/default/qr/edit.php:85
        #: storage/themes/default/qr/new.php:73 storage/themes/default/qr/new.php:99
        "Message" => "",
        #: app/controllers/user/OverlayController.php:290
        #: app/controllers/user/OverlayController.php:450
        "send" => "",
        #: app/controllers/user/OverlayController.php:298
        #: app/controllers/user/OverlayController.php:458
        #: app/controllers/user/OverlayController.php:586
        #: app/controllers/user/OverlayController.php:728
        #: app/controllers/user/OverlayController.php:877
        #: app/controllers/user/OverlayController.php:1045
        #: app/controllers/user/OverlayController.php:1169
        #: app/controllers/user/OverlayController.php:1305
        #: app/controllers/user/OverlayController.php:1453
        #: app/controllers/user/OverlayController.php:1587
        "The name field cannot be empty." => "",
        #: app/controllers/user/OverlayController.php:332
        #: app/controllers/user/OverlayController.php:622
        #: app/controllers/user/OverlayController.php:923
        #: app/controllers/user/OverlayController.php:1222
        #: app/controllers/user/OverlayController.php:1478
        "Overlay has been successfully created." => "",
        #: app/controllers/user/OverlayController.php:349
        #: app/controllers/user/OverlayController.php:639
        #: app/controllers/user/OverlayController.php:940
        #: app/controllers/user/OverlayController.php:1239
        #: app/controllers/user/OverlayController.php:1508
        #: storage/themes/default/overlay/index.php:26
        #: storage/themes/default/partials/links.php:9
        #: storage/themes/default/splash/index.php:28
        #: storage/themes/default/teams/index.php:27
        #: storage/themes/default/user/campaigns.php:24
        "Edit" => "",
        #: app/controllers/user/OverlayController.php:488
        #: app/controllers/user/OverlayController.php:759
        #: app/controllers/user/OverlayController.php:1090
        #: app/controllers/user/OverlayController.php:1361
        #: app/controllers/user/OverlayController.php:1608
        "Overlay has been successfully updated." => "",
        #: app/controllers/user/OverlayController.php:588
        #: app/controllers/user/OverlayController.php:730
        "Please enter a valid question." => "",
        #: app/controllers/user/OverlayController.php:590
        #: app/controllers/user/OverlayController.php:732
        "A minimum of two options is required." => "",
        #: app/controllers/user/OverlayController.php:604
        #: app/controllers/user/OverlayController.php:746 app/traits/Overlays.php:207
        #: storage/themes/default/overlay/create_poll.php:48
        #: storage/themes/default/overlay/create_poll.php:112
        "Vote" => "",
        #: app/controllers/user/OverlayController.php:879
        #: app/controllers/user/OverlayController.php:1047
        "The message field cannot be empty." => "",
        #: app/controllers/user/OverlayController.php:881
        #: app/controllers/user/OverlayController.php:1049
        #: app/controllers/user/OverlayController.php:1171
        #: app/controllers/user/OverlayController.php:1307
        #: app/controllers/user/SplashController.php:111
        #: app/controllers/user/SplashController.php:211 app/traits/Links.php:77
        #: app/traits/Links.php:398 storage/themes/default/layouts/dashboard.php:107
        #: storage/themes/default/layouts/main.php:57
        "Please enter a valid URL." => "",
        #: app/controllers/user/OverlayController.php:900
        #: app/controllers/user/OverlayController.php:902
        #: app/controllers/user/OverlayController.php:1068
        #: app/controllers/user/OverlayController.php:1070
        #: app/controllers/user/OverlayController.php:1183
        #: app/controllers/user/OverlayController.php:1185
        #: app/controllers/user/OverlayController.php:1319
        #: app/controllers/user/OverlayController.php:1321
        #: app/controllers/user/QRController.php:228
        #: app/controllers/user/QRController.php:375
        "Logo must be either a PNG or a JPEG (Max 500kb)." => "",
        #: app/controllers/user/OverlayController.php:906
        #: app/controllers/user/OverlayController.php:1074
        #: app/controllers/user/OverlayController.php:1189
        #: app/controllers/user/OverlayController.php:1325
        "Logo must be either a PNG or a JPEG with a recommended dimension of 100x100." => "",
        #: app/controllers/user/OverlayController.php:1173
        "You need to upload your logo and/or a background." => "",
        #: app/controllers/user/OverlayController.php:1199
        #: app/controllers/user/OverlayController.php:1201
        #: app/controllers/user/OverlayController.php:1339
        #: app/controllers/user/OverlayController.php:1341
        "Image must be either a PNG or a JPEG (Max 1mb)." => "",
        #: app/controllers/user/OverlayController.php:1205
        #: app/controllers/user/OverlayController.php:1345
        "Image must be either a PNG or a JPEG with a recommended dimension of 600x150." => "",
        #: app/controllers/user/OverlayController.php:1631
        "Overlay not found. Please try again." => "",
        #: app/controllers/user/OverlayController.php:1644
        "Overlay has been deleted." => "",
        #: app/controllers/user/PixelsController.php:56
        #: storage/themes/default/partials/sidebar_menu.php:66
        #: storage/themes/default/pixels/index.php:3
        #: storage/themes/default/teams/edit.php:47
        #: storage/themes/default/teams/index.php:149
        "Tracking Pixels" => "",
        #: app/controllers/user/PixelsController.php:78
        "New Pixel" => "",
        #: app/controllers/user/PixelsController.php:108
        "Please enter valid id." => "",
        #: app/controllers/user/PixelsController.php:112
        "Facebook pixel ID is not correct. Please double check." => "",
        #: app/controllers/user/PixelsController.php:117
        "Google Ads pixel ID is not correct. Please double check." => "",
        #: app/controllers/user/PixelsController.php:122
        "LinkedIn ID is not correct. Please double check." => "",
        #: app/controllers/user/PixelsController.php:127
        "Twitter ID is not correct. Please double check." => "",
        #: app/controllers/user/PixelsController.php:132
        "AdRoll ID is not correct. Please double check." => "",
        #: app/controllers/user/PixelsController.php:137
        "Quora ID is not correct. Please double check." => "",
        #: app/controllers/user/PixelsController.php:142
        "GTM container ID is not correct. Please double check." => "",
        #: app/controllers/user/PixelsController.php:147
        "Google Analytics ID is not correct. Please double check." => "",
        #: app/controllers/user/PixelsController.php:161
        "Pixel has been added successfully" => "",
        #: app/controllers/user/PixelsController.php:175
        #: app/controllers/user/PixelsController.php:197
        #: app/controllers/user/PixelsController.php:225
        "Pixel not found. Please try again." => "",
        #: app/controllers/user/PixelsController.php:178
        #: storage/themes/default/pixels/edit.php:3
        #: storage/themes/default/pixels/index.php:25
        "Edit Pixel" => "",
        #: app/controllers/user/PixelsController.php:205
        "Pixel has been updated successfully." => "",
        #: app/controllers/user/PixelsController.php:235
        "Pixel has been deleted." => "",
        #: app/controllers/user/QRController.php:89
        #: storage/themes/default/qr/index.php:6
        #: storage/themes/default/qr/index.php:46 storage/themes/default/qr/new.php:1
        #: storage/themes/default/teams/edit.php:20
        #: storage/themes/default/teams/index.php:122
        "Create QR" => "",
        #: app/controllers/user/QRController.php:145
        "Please enter a name for your QR code." => "",
        #: app/controllers/user/QRController.php:147
        #: app/controllers/user/QRController.php:194 app/helpers/QR.php:280
        #: app/helpers/QR.php:309
        "Invalid QR format or missing data" => "",
        #: app/controllers/user/QRController.php:272
        "QR Code has been successfully generated." => "",
        #: app/controllers/user/QRController.php:329
        #: storage/themes/default/qr/edit.php:1 storage/themes/default/qr/index.php:23
        #: storage/themes/default/teams/edit.php:21
        #: storage/themes/default/teams/index.php:123
        "Edit QR" => "",
        #: app/controllers/user/QRController.php:406
        "QR Code has been successfully updated." => "",
        #: app/controllers/user/SplashController.php:58
        #: storage/themes/default/splash/index.php:3
        #: storage/themes/default/splash/index.php:55
        "Custom Splash Pages" => "",
        #: app/controllers/user/SplashController.php:84
        #: storage/themes/default/splash/create.php:1
        #: storage/themes/default/splash/edit.php:1
        #: storage/themes/default/splash/index.php:6
        #: storage/themes/default/splash/index.php:46
        "Create a Custom Splash" => "",
        #: app/controllers/user/SplashController.php:109
        #: app/controllers/user/SplashController.php:209
        "The name, title, message and link cannot be empty." => "",
        #: app/controllers/user/SplashController.php:112
        #: app/controllers/user/SplashController.php:212
        "Please enter a valid counter time in seconds." => "",
        #: app/controllers/user/SplashController.php:125
        #: app/controllers/user/SplashController.php:127
        #: app/controllers/user/SplashController.php:227
        #: app/controllers/user/SplashController.php:229
        "Avatar must be either a PNG or a JPEG (Max 300kb)." => "",
        #: app/controllers/user/SplashController.php:141
        #: app/controllers/user/SplashController.php:143
        #: app/controllers/user/SplashController.php:247
        #: app/controllers/user/SplashController.php:249
        "Banner must be either a PNG or a JPEG (Max 500kb)." => "",
        #: app/controllers/user/SplashController.php:147
        #: app/controllers/user/SplashController.php:253
        "Banner must be either a PNG or a JPEG with a recommended dimension of 980x300." => "",
        #: app/controllers/user/SplashController.php:163
        "Custom splash page has been created." => "",
        #: app/controllers/user/SplashController.php:180
        #: app/controllers/user/SplashController.php:206
        #: app/controllers/user/SplashController.php:286
        "Custom splash page does not exist." => "",
        #: app/controllers/user/SplashController.php:185
        "Update a Custom Splash" => "",
        #: app/controllers/user/SplashController.php:268
        "Custom splash page has been updated." => "",
        #: app/controllers/user/SplashController.php:303
        "Custom splash page has been deleted." => "",
        #: app/controllers/user/StatsController.php:40
        #: storage/themes/default/bio/index.php:30
        #: storage/themes/default/partials/links.php:7
        #: storage/themes/default/partials/sidebar_menu.php:23
        #: storage/themes/default/qr/index.php:24
        #: storage/themes/default/user/campaigns.php:25
        #: storage/themes/default/user/edit.php:6
        #: storage/themes/default/user/stats.php:3
        "Statistics" => "",
        #: app/controllers/user/TeamsController.php:59
        #: storage/themes/default/teams/index.php:3
        "Manage Teams" => "",
        #: app/controllers/user/TeamsController.php:83
        "This is not a valid email address" => "",
        #: app/controllers/user/TeamsController.php:86
        "This user has already an account. Please use another email." => "",
        #: app/controllers/user/TeamsController.php:90
        "This email address has been invited." => "",
        #: app/controllers/user/TeamsController.php:93
        "No permission has been assigned for this user." => "",
        #: app/controllers/user/TeamsController.php:115
        "An invite has been sent to the email." => "",
        #: app/controllers/user/ToolsController.php:37
        #: storage/themes/default/partials/sidebar_menu.php:87
        #: storage/themes/default/user/tools.php:1
        "Tools" => "",
        #: app/controllers/user/ToolsController.php:63
        "The application has been install on your slack account. You can now use the command to shorten links directly from your conversations." => "",
        #: app/controllers/user/ToolsController.php:88
        "Your Zapier URL has been updated." => "",
        #: app/helpers/App.php:682
        "Redirection" => "",
        #: app/helpers/App.php:684 storage/themes/default/user/settings.php:85
        "Frame" => "",
        #: app/helpers/App.php:685 storage/themes/default/user/settings.php:86
        "Splash" => "",
        #: app/helpers/App.php:697 storage/themes/default/partials/sidebar_menu.php:52
        #: storage/themes/default/pricing/index.php:51
        #: storage/themes/default/teams/edit.php:33
        #: storage/themes/default/teams/index.php:135
        #: storage/themes/default/user/billing.php:79
        "Custom Splash" => "",
        #: app/helpers/Captcha.php:114 app/helpers/Captcha.php:123
        #: app/helpers/Captcha.php:193 app/helpers/Captcha.php:201
        "The captcha did not validate. Please try again." => "",
        #: app/helpers/Emails.php:64
        "Please verify your email" => "",
        #: app/helpers/Emails.php:108
        "Registration has been successful" => "",
        #: app/helpers/Emails.php:155
        "Password Reset Instructions" => "",
        #: app/helpers/Emails.php:199
        "Your email has been verified" => "",
        #: app/helpers/Emails.php:236
        "Your password was changed." => "",
        #: app/helpers/Emails.php:243
        "Your password was changed. If you did not change your password, please contact us as soon as possible." => "",
        #: app/helpers/Emails.php:274
        "You just got paid!" => "",
        #: app/helpers/Emails.php:281
        "You just got paid {amount} via PayPal for being an awesome affiliate!" => "",
        #: app/helpers/Emails.php:320
        "You have been invited to join our team" => "",
        #: app/helpers/Emails.php:358
        "Your subscription has been canceled" => "",
        #: app/helpers/Gate.php:39
        "Inactive Link" => "",
        #: app/helpers/Gate.php:54
        "Unsafe Link Detected" => "",
        #: app/helpers/Gate.php:68
        "Link Expired" => "",
        #: app/helpers/Gate.php:81
        "Enter your password to unlock this link" => "",
        #: app/helpers/Gate.php:82
        "The access to this link is restricted. Please enter your password to view it." => "",
        #: app/helpers/Gate.php:88 app/helpers/Gate.php:177 app/helpers/Gate.php:379
        "Adblock Detected" => "",
        #: app/helpers/Gate.php:88 app/helpers/Gate.php:177 app/helpers/Gate.php:379
        "Please disable Adblock and refresh the page again." => "",
        #: app/helpers/Gate.php:168 storage/themes/default/layouts/dashboard.php:110
        "Continue" => "",
        #: app/helpers/Gate.php:454 storage/themes/default/user/campaigns.php:35
        "List" => "",
        #: app/helpers/QR.php:109 app/helpers/QR.php:121
        "QR data cannot be empty. Please fill the appropriate field." => "",
        #: app/helpers/QR.php:163 app/helpers/QR.php:179
        "Invalid phone number. Please try again." => "",
        #: app/helpers/QR.php:240
        "vCard data cannot be empty. Please fill some fields" => "",
        #: app/helpers/QR.php:286
        "Please enter the Wifi SSID" => "",
        #: app/helpers/Slack.php:104
        "You need to allow this application to install the commands on your slack account." => "",
        #: app/helpers/payments/Bank.php:48 app/traits/Payments.php:92
        #: app/traits/Payments.php:93
        "Bank Transfer" => "",
        #: app/helpers/payments/Bank.php:51 app/helpers/payments/Paypal.php:53
        #: app/helpers/payments/PaypalApi.php:55 app/helpers/payments/Stripe.php:56
        "Enable" => "",
        #: app/helpers/payments/Bank.php:53
        "Transfer payments via your bank." => "",
        #: app/helpers/payments/Bank.php:56
        "Bank Info" => "",
        #: app/helpers/payments/Bank.php:58
        "Enter the full information where your users can send payments to via their bank." => "",
        #: app/helpers/payments/Bank.php:76
        "Bank Information" => "",
        #: app/helpers/payments/Bank.php:93 app/helpers/payments/Bank.php:98
        #: app/helpers/payments/Paypal.php:95 app/helpers/payments/Paypal.php:99
        #: app/helpers/payments/PaypalApi.php:102
        #: app/helpers/payments/PaypalApi.php:106 app/helpers/payments/Stripe.php:169
        #: app/helpers/payments/Stripe.php:173 app/helpers/payments/Stripe.php:195
        #: app/helpers/payments/Stripe.php:226 app/helpers/payments/Stripe.php:229
        #: app/helpers/payments/Stripe.php:245 app/helpers/payments/Stripe.php:297
        #: app/helpers/payments/Stripe.php:309 app/helpers/payments/Stripe.php:342
        "An error ocurred, please try again. You have not been charged." => "",
        #: app/helpers/payments/Bank.php:102 app/helpers/payments/Stripe.php:177
        "First month" => "",
        #: app/helpers/payments/Bank.php:108 app/helpers/payments/Stripe.php:183
        "First year" => "",
        #: app/helpers/payments/Bank.php:115 app/helpers/payments/Stripe.php:190
        #: storage/themes/default/pricing/index.php:18
        "Lifetime" => "",
        #: app/helpers/payments/Bank.php:139
        "Your subscription is currently pending. Once we receive the money, we will activate your subscription." => "",
        #: app/helpers/payments/Paypal.php:50
        "Paypal Basic Checkout" => "",
        #: app/helpers/payments/Paypal.php:55
        "Collect payments via basic paypal checkout." => "",
        #: app/helpers/payments/Paypal.php:59 storage/themes/default/bio/edit.php:361
        #: storage/themes/default/bio/new.php:347
        "PayPal Email" => "",
        #: app/helpers/payments/Paypal.php:61
        "Payments will be sent to this address. Please make sure that you enable IPN and enable notification." => "",
        #: app/helpers/payments/Paypal.php:64
        "PayPal IPN" => "",
        #: app/helpers/payments/Paypal.php:66
        "For more info <a href=\"https://developer.paypal.com/webapps/developer/docs/classic/products/instant-payment-notification/\" target=\"_blank\">click here</a>" => "",
        #: app/helpers/payments/Paypal.php:145 app/helpers/payments/Paypal.php:247
        #: app/helpers/payments/PaypalApi.php:394
        "Your payment has been canceled." => "",
        #: app/helpers/payments/Paypal.php:154
        "Payment complete. We will upgrade your account as soon as the payment is verified." => "",
        #: app/helpers/payments/Paypal.php:244 app/helpers/payments/PaypalApi.php:323
        #: app/helpers/payments/PaypalApi.php:383
        "Your payment was successfully made. Thank you." => "",
        #: app/helpers/payments/PaypalApi.php:52
        "Paypal API Payments" => "",
        #: app/helpers/payments/PaypalApi.php:57
        "Collect payments securely with PayPal API." => "",
        #: app/helpers/payments/PaypalApi.php:61
        "Client ID" => "",
        #: app/helpers/payments/PaypalApi.php:63
        "Please enter your live client ID." => "",
        #: app/helpers/payments/PaypalApi.php:66
        "Client Secret Key" => "",
        #: app/helpers/payments/PaypalApi.php:68
        "Please enter your live client secret." => "",
        #: app/helpers/payments/PaypalApi.php:74
        "You cannot enable both basic paypal and paypal api at the same time. You must choose one." => "",
        #: app/helpers/payments/PaypalApi.php:169
        #: app/helpers/payments/PaypalApi.php:231
        #: app/helpers/payments/PaypalApi.php:234
        #: app/helpers/payments/PaypalApi.php:328
        #: app/helpers/payments/PaypalApi.php:331
        #: app/helpers/payments/PaypalApi.php:345
        #: app/helpers/payments/PaypalApi.php:349
        #: app/helpers/payments/PaypalApi.php:388
        #: app/helpers/payments/PaypalApi.php:391
        "An issue occurred. You have not been charged." => "",
        #: app/helpers/payments/PaypalApi.php:289
        "An issue occurred. Please contact us for more info." => "",
        #: app/helpers/payments/Stripe.php:53
        "Stripe Payments" => "",
        #: app/helpers/payments/Stripe.php:58
        "Collect payments securely with Stripe." => "",
        #: app/helpers/payments/Stripe.php:62
        "Stripe Publishable Key" => "",
        #: app/helpers/payments/Stripe.php:64 app/helpers/payments/Stripe.php:69
        "Get your stripe keys from here once logged in <a href=\"https://dashboard.stripe.com/account/apikeys\" target=\"_blank\">click here</a>" => "",
        #: app/helpers/payments/Stripe.php:67
        "Stripe Secret Key" => "",
        #: app/helpers/payments/Stripe.php:72
        "Webhook Signature Key" => "",
        #: app/helpers/payments/Stripe.php:74
        "Webhook signature is a security measure to verify the authenticity of the data incoming from Stripe. It is highly recommended that you add this for safety measure. You can find your key after adding a webhook. <a href=\"https://dashboard.stripe.com/account/webhooks\" target=\"_blank\">Click here to find your signature key.</a>" => "",
        #: app/helpers/payments/Stripe.php:77
        "Webhook URL" => "",
        #: app/helpers/payments/Stripe.php:79
        "You can add your webhooks <a href=\"https://dashboard.stripe.com/account/webhooks\" target=\"_blank\">here</a>. For more info, please check the docs." => "",
        #: app/helpers/payments/Stripe.php:147
        "Credit or debit card" => "",
        #: app/helpers/payments/Stripe.php:331
        "Your credit card was declined. Please check your credit card and try again later." => "",
        #: app/helpers/payments/Stripe.php:391
        "You have a new Subscriber" => "",
        #: app/helpers/payments/Stripe.php:538
        "Payment failed" => "",
        #: app/middleware/Auth.php:59
        "Please upgrade to a premium package in order to continue." => "",
        #: app/middleware/CheckDomain.php:51
        "Great! Your domain is working." => "",
        #: app/middleware/CheckMaintenance.php:34
        "Offline for Maintenance" => "",
        #: app/middleware/CheckPrivate.php:40
        "Private Use" => "",
        #: app/traits/Links.php:69
        "Please create a free account or login to shorten links." => "",
        #: app/traits/Links.php:71
        "You have reached your maximum links limit. Please upgrade to another plan." => "",
        #: app/traits/Links.php:74
        "This service is meant to be used internally only." => "",
        #: app/traits/Links.php:80 app/traits/Links.php:401
        "You cannot shorten URLs of this website." => "",
        #: app/traits/Links.php:83 app/traits/Links.php:404
        "This domain name or link has been blacklisted." => "",
        #: app/traits/Links.php:86 app/traits/Links.php:407
        "This URL contains blacklisted keywords." => "",
        #: app/traits/Links.php:89 app/traits/Links.php:92 app/traits/Links.php:95
        #: app/traits/Links.php:410 app/traits/Links.php:413 app/traits/Links.php:416
        "URL is suspected to contain malware and other harmful content." => "",
        #: app/traits/Links.php:98 app/traits/Links.php:419
        "Linking to executable files is not allowed." => "",
        #: app/traits/Links.php:101 app/traits/Links.php:422
        "The expiry date must be later than today." => "",
        #: app/traits/Links.php:203 app/traits/Links.php:205 app/traits/Links.php:547
        #: app/traits/Links.php:549
        "Banner must be either a PNG or a JPEG (Max 200kb)." => "",
        #: app/traits/Links.php:257 app/traits/Links.php:275 app/traits/Links.php:303
        "Link has been shortened" => "",
        #: app/traits/Links.php:285
        "You have maxed your short URLs limit. Either delete existing URLs or upgrade to a premium plan." => "",
        #: app/traits/Links.php:290 app/traits/Links.php:522
        "This URL cannot be used with this redirect method because browsers will prevent it for security reasons." => "",
        #: app/traits/Overlays.php:38
        "CTA Contact" => "",
        #: app/traits/Overlays.php:39
        "Create a contact form where users will be able to contact you via email." => "",
        #: app/traits/Overlays.php:48
        "CTA Poll" => "",
        #: app/traits/Overlays.php:49
        "Create a quick poll where users will be able to answer it upon visit." => "",
        #: app/traits/Overlays.php:58
        "CTA Message" => "",
        #: app/traits/Overlays.php:59
        "Create a small popup with a message and a link to a page or a product." => "",
        #: app/traits/Overlays.php:68
        "CTA Newsletter" => "",
        #: app/traits/Overlays.php:69
        "Create a small popup form to collect emails from users." => "",
        #: app/traits/Overlays.php:78
        "CTA Image" => "",
        #: app/traits/Overlays.php:79
        "Create a small popup with an image of your choice." => "",
        #: app/traits/Payments.php:45 app/traits/Payments.php:77
        "PayPal" => "",
        #: app/traits/Payments.php:61
        "Credit Card" => "",
        #: app/traits/Payments.php:94
        "Transfer payments via your bank" => "",
        #: storage/themes/default/auth/2fa.php:15
        "The access code can be found on the Authenticator app. Please enter the code shown for this website. If you lost your phone or can't use the app, please contact us." => "",
        #: storage/themes/default/auth/2fa.php:22
        "2FA Access Code" => "",
        #: storage/themes/default/auth/2fa.php:31
        "Validate" => "",
        #: storage/themes/default/auth/invite.php:15
        "Join team and manage collaborate on everything" => "",
        #: storage/themes/default/auth/invite.php:31
        #: storage/themes/default/auth/register.php:19
        #: storage/themes/default/user/settings.php:43
        "Username" => "",
        #: storage/themes/default/auth/invite.php:40
        #: storage/themes/default/auth/login.php:28
        #: storage/themes/default/auth/register.php:39
        #: storage/themes/default/gates/password.php:22
        #: storage/themes/default/qr/edit.php:181
        #: storage/themes/default/qr/new.php:191
        #: storage/themes/default/user/billing.php:121
        #: storage/themes/default/user/settings.php:52
        "Password" => "",
        #: storage/themes/default/auth/invite.php:49
        #: storage/themes/default/auth/register.php:52
        #: storage/themes/default/auth/reset.php:30
        #: storage/themes/default/user/settings.php:59
        #: storage/themes/default/user/settings.php:193
        "Confirm Password" => "",
        #: storage/themes/default/auth/invite.php:61
        #: storage/themes/default/auth/register.php:66
        "I agree to the" => "",
        #: storage/themes/default/auth/invite.php:68
        #: storage/themes/default/auth/register.php:73
        "I agree to the terms and conditions" => "",
        #: storage/themes/default/auth/invite.php:73
        "Accept" => "",
        #: storage/themes/default/auth/login.php:17
        "Email or username" => "",
        #: storage/themes/default/auth/login.php:40
        "Forgot Password?" => "",
        #: storage/themes/default/auth/login.php:47
        "Remember me" => "",
        #: storage/themes/default/auth/login.php:53
        #: storage/themes/default/auth/register.php:84
        #: storage/themes/default/partials/main_menu.php:100
        #: storage/themes/default/partials/main_menu.php:125
        "Login" => "",
        #: storage/themes/default/auth/login.php:59
        "or" => "",
        #: storage/themes/default/auth/login.php:65
        #: storage/themes/default/auth/login.php:66
        #: storage/themes/default/auth/login.php:73
        #: storage/themes/default/auth/login.php:74
        #: storage/themes/default/auth/login.php:81
        #: storage/themes/default/auth/login.php:82
        "Sign in with" => "",
        #: storage/themes/default/auth/login.php:93
        #: storage/themes/default/partials/footer.php:75
        "All Rights Reserved" => "",
        #: storage/themes/default/auth/login.php:100
        "Don't have an account?" => "",
        #: storage/themes/default/auth/login.php:102
        #: storage/themes/default/auth/login.php:108
        #: storage/themes/default/auth/register.php:13
        #: storage/themes/default/partials/footer.php:10
        "Start your marketing campaign now and reach your customers efficiently." => "",
        #: storage/themes/default/auth/login.php:104
        #: storage/themes/default/auth/register.php:80
        "Register" => "",
        #: storage/themes/default/auth/register.php:12
        "Create your account" => "",
        #: storage/themes/default/auth/register.php:21
        "Please enter a username" => "",
        #: storage/themes/default/auth/register.php:28
        "Email address" => "",
        #: storage/themes/default/auth/register.php:43
        "Please enter a valid password." => "",
        #: storage/themes/default/auth/register.php:56
        "Please confirm your password." => "",
        #: storage/themes/default/auth/register.php:83
        "Already have an account?" => "",
        #: storage/themes/default/auth/reset.php:21
        "New Password" => "",
        #: storage/themes/default/bio/edit.php:6
        #: storage/themes/default/bio/index.php:26
        "View Bio" => "",
        #: storage/themes/default/bio/edit.php:15 storage/themes/default/bio/new.php:8
        "Bio Page Name" => "",
        #: storage/themes/default/bio/edit.php:19
        #: storage/themes/default/bio/new.php:12
        "Bio Page Alias" => "",
        #: storage/themes/default/bio/edit.php:23
        #: storage/themes/default/bio/new.php:24
        "Leave this field empty to generate a random alias." => "",
        #: storage/themes/default/bio/edit.php:38
        #: storage/themes/default/bio/new.php:35
        "Custom Avatar" => "",
        #: storage/themes/default/bio/edit.php:40
        #: storage/themes/default/bio/new.php:37
        "We recommend you choose a square picture with a maximum size of 300x300 and 500kb." => "",
        #: storage/themes/default/bio/edit.php:50
        #: storage/themes/default/bio/new.php:47
        "Social Links" => "",
        #: storage/themes/default/bio/edit.php:53
        #: storage/themes/default/bio/edit.php:102
        #: storage/themes/default/bio/new.php:50 storage/themes/default/bio/new.php:97
        "Appearance" => "",
        #: storage/themes/default/bio/edit.php:67
        #: storage/themes/default/bio/edit.php:231
        #: storage/themes/default/bio/new.php:62
        #: storage/themes/default/bio/new.php:217
        "Add Link or Content" => "",
        #: storage/themes/default/bio/edit.php:75
        #: storage/themes/default/bio/new.php:70
        #: storage/themes/default/qr/edit.php:151
        #: storage/themes/default/qr/new.php:163
        "Facebook" => "",
        #: storage/themes/default/bio/edit.php:76
        #: storage/themes/default/bio/edit.php:80
        #: storage/themes/default/bio/edit.php:84
        #: storage/themes/default/bio/edit.php:88
        #: storage/themes/default/bio/edit.php:92
        #: storage/themes/default/bio/edit.php:96
        #: storage/themes/default/bio/edit.php:306
        #: storage/themes/default/bio/new.php:71 storage/themes/default/bio/new.php:75
        #: storage/themes/default/bio/new.php:79 storage/themes/default/bio/new.php:83
        #: storage/themes/default/bio/new.php:87 storage/themes/default/bio/new.php:91
        #: storage/themes/default/bio/new.php:292
        "Please enter a valid link" => "",
        #: storage/themes/default/bio/edit.php:79
        #: storage/themes/default/bio/new.php:74
        #: storage/themes/default/qr/edit.php:155
        #: storage/themes/default/qr/new.php:167
        "Twitter" => "",
        #: storage/themes/default/bio/edit.php:83
        #: storage/themes/default/bio/new.php:78
        #: storage/themes/default/qr/edit.php:159
        #: storage/themes/default/qr/new.php:171
        "Instagram" => "",
        #: storage/themes/default/bio/edit.php:87
        #: storage/themes/default/bio/new.php:82
        "Tiktok" => "",
        #: storage/themes/default/bio/edit.php:91
        #: storage/themes/default/bio/new.php:86
        "Linkedin" => "",
        #: storage/themes/default/bio/edit.php:95
        #: storage/themes/default/bio/new.php:90
        "Youtube" => "",
        #: storage/themes/default/bio/edit.php:105
        #: storage/themes/default/bio/new.php:100
        "Templates" => "",
        #: storage/themes/default/bio/edit.php:151
        #: storage/themes/default/bio/edit.php:162
        #: storage/themes/default/bio/new.php:146
        #: storage/themes/default/bio/new.php:157
        #: storage/themes/default/qr/edit.php:212
        #: storage/themes/default/qr/edit.php:230
        #: storage/themes/default/qr/new.php:226 storage/themes/default/qr/new.php:244
        "Background" => "",
        #: storage/themes/default/bio/edit.php:154
        #: storage/themes/default/bio/new.php:149
        #: storage/themes/default/qr/edit.php:203
        #: storage/themes/default/qr/new.php:217
        "Single Color" => "",
        #: storage/themes/default/bio/edit.php:155
        #: storage/themes/default/bio/new.php:150
        #: storage/themes/default/qr/edit.php:204
        #: storage/themes/default/qr/new.php:218
        "Gradient Color" => "",
        #: storage/themes/default/bio/edit.php:172
        #: storage/themes/default/bio/new.php:167
        #: storage/themes/default/qr/edit.php:237
        #: storage/themes/default/qr/new.php:251
        "Gradient Start" => "",
        #: storage/themes/default/bio/edit.php:178
        #: storage/themes/default/bio/new.php:173
        #: storage/themes/default/qr/edit.php:241
        #: storage/themes/default/qr/new.php:255
        "Gradient Stop" => "",
        #: storage/themes/default/bio/edit.php:184
        #: storage/themes/default/bio/new.php:179
        "Text Color" => "",
        #: storage/themes/default/bio/edit.php:188
        #: storage/themes/default/bio/new.php:183
        "Button Color" => "",
        #: storage/themes/default/bio/edit.php:192
        #: storage/themes/default/bio/new.php:187
        "Button text Color" => "",
        #: storage/themes/default/bio/edit.php:225
        #: storage/themes/default/overlay/edit_contact.php:152
        #: storage/themes/default/overlay/edit_message.php:110
        #: storage/themes/default/overlay/edit_newsletter.php:104
        #: storage/themes/default/overlay/edit_poll.php:100
        #: storage/themes/default/qr/edit.php:355
        #: storage/themes/default/splash/edit.php:58
        "Update" => "",
        #: storage/themes/default/bio/edit.php:241
        #: storage/themes/default/bio/edit.php:290
        #: storage/themes/default/bio/edit.php:293
        #: storage/themes/default/bio/edit.php:301
        #: storage/themes/default/bio/new.php:227
        #: storage/themes/default/bio/new.php:276
        #: storage/themes/default/bio/new.php:279
        #: storage/themes/default/bio/new.php:287
        #: storage/themes/default/qr/edit.php:17 storage/themes/default/qr/new.php:12
        #: storage/themes/default/qr/new.php:39
        "Text" => "",
        #: storage/themes/default/bio/edit.php:253
        #: storage/themes/default/bio/edit.php:318
        #: storage/themes/default/bio/new.php:239
        #: storage/themes/default/bio/new.php:304
        "Youtube Video" => "",
        #: storage/themes/default/bio/edit.php:259
        #: storage/themes/default/bio/edit.php:326
        #: storage/themes/default/bio/new.php:245
        #: storage/themes/default/bio/new.php:312
        "WhatsApp Call" => "",
        #: storage/themes/default/bio/edit.php:267
        #: storage/themes/default/bio/edit.php:338
        #: storage/themes/default/bio/new.php:253
        #: storage/themes/default/bio/new.php:324
        "Spotify Embed" => "",
        #: storage/themes/default/bio/edit.php:273
        #: storage/themes/default/bio/edit.php:346
        #: storage/themes/default/bio/new.php:259
        #: storage/themes/default/bio/new.php:332
        "Apple Music Embed" => "",
        #: storage/themes/default/bio/edit.php:279
        #: storage/themes/default/bio/new.php:265
        "Paypal Button" => "",
        #: storage/themes/default/bio/edit.php:285
        #: storage/themes/default/bio/edit.php:378
        #: storage/themes/default/bio/new.php:271
        #: storage/themes/default/bio/new.php:364
        "Tiktok Embed" => "",
        #: storage/themes/default/bio/edit.php:291
        #: storage/themes/default/bio/edit.php:299
        #: storage/themes/default/bio/edit.php:311
        #: storage/themes/default/bio/edit.php:319
        #: storage/themes/default/bio/edit.php:327
        #: storage/themes/default/bio/edit.php:339
        #: storage/themes/default/bio/edit.php:347
        #: storage/themes/default/bio/edit.php:355
        #: storage/themes/default/bio/edit.php:379
        #: storage/themes/default/bio/new.php:277
        #: storage/themes/default/bio/new.php:285
        #: storage/themes/default/bio/new.php:297
        #: storage/themes/default/bio/new.php:305
        #: storage/themes/default/bio/new.php:313
        #: storage/themes/default/bio/new.php:325
        #: storage/themes/default/bio/new.php:333
        #: storage/themes/default/bio/new.php:341
        #: storage/themes/default/bio/new.php:365
        "Back" => "",
        #: storage/themes/default/bio/edit.php:296
        #: storage/themes/default/bio/new.php:282
        "Add Text" => "",
        #: storage/themes/default/bio/edit.php:305
        #: storage/themes/default/bio/new.php:291
        #: storage/themes/default/overlay/create_image.php:18
        #: storage/themes/default/overlay/edit_image.php:18
        #: storage/themes/default/qr/edit.php:30 storage/themes/default/qr/new.php:21
        #: storage/themes/default/qr/new.php:50
        "Link" => "",
        #: storage/themes/default/bio/edit.php:308
        #: storage/themes/default/bio/new.php:294
        "Add Link" => "",
        #: storage/themes/default/bio/edit.php:310
        #: storage/themes/default/bio/edit.php:313
        #: storage/themes/default/bio/new.php:296
        #: storage/themes/default/bio/new.php:299
        "Image" => "",
        #: storage/themes/default/bio/edit.php:316
        #: storage/themes/default/bio/new.php:302
        "Add Image" => "",
        #: storage/themes/default/bio/edit.php:321
        #: storage/themes/default/bio/new.php:307
        "Link to Video" => "",
        #: storage/themes/default/bio/edit.php:322
        #: storage/themes/default/bio/new.php:308
        "Please enter a valid youtube link" => "",
        #: storage/themes/default/bio/edit.php:324
        #: storage/themes/default/bio/new.php:310
        "Add Youtube Video" => "",
        #: storage/themes/default/bio/edit.php:329
        #: storage/themes/default/bio/new.php:315
        #: storage/themes/default/qr/edit.php:68 storage/themes/default/qr/edit.php:81
        #: storage/themes/default/qr/new.php:84 storage/themes/default/qr/new.php:95
        "Phone Number" => "",
        #: storage/themes/default/bio/edit.php:333
        #: storage/themes/default/bio/edit.php:357
        #: storage/themes/default/bio/new.php:319
        #: storage/themes/default/bio/new.php:343
        "Label" => "",
        #: storage/themes/default/bio/edit.php:336
        #: storage/themes/default/bio/new.php:322
        "Add WhatsApp Call" => "",
        #: storage/themes/default/bio/edit.php:341
        #: storage/themes/default/bio/new.php:327
        "Link to Spotify Song" => "",
        #: storage/themes/default/bio/edit.php:342
        #: storage/themes/default/bio/new.php:328
        "Please enter a valid spotify link" => "",
        #: storage/themes/default/bio/edit.php:344
        #: storage/themes/default/bio/new.php:330
        "Add Spotify" => "",
        #: storage/themes/default/bio/edit.php:349
        #: storage/themes/default/bio/new.php:335
        "Link to Apple Music Song" => "",
        #: storage/themes/default/bio/edit.php:350
        #: storage/themes/default/bio/new.php:336
        "Please enter a valid apple music link" => "",
        #: storage/themes/default/bio/edit.php:352
        #: storage/themes/default/bio/new.php:338
        "Add Apple Music" => "",
        #: storage/themes/default/bio/edit.php:354
        #: storage/themes/default/bio/new.php:340
        "PayPal Button" => "",
        #: storage/themes/default/bio/edit.php:365
        #: storage/themes/default/bio/new.php:351
        #: storage/themes/default/invoice.php:59
        #: storage/themes/default/user/billing.php:14
        #: storage/themes/default/user/billing.php:44
        "Amount" => "",
        #: storage/themes/default/bio/edit.php:369
        #: storage/themes/default/bio/new.php:355
        "Currency" => "",
        #: storage/themes/default/bio/edit.php:376
        #: storage/themes/default/bio/new.php:362
        "Add Paypal" => "",
        #: storage/themes/default/bio/edit.php:381
        #: storage/themes/default/bio/new.php:367
        "Link to Tiktok Video" => "",
        #: storage/themes/default/bio/edit.php:382
        #: storage/themes/default/bio/new.php:368
        "Please enter a valid tiktok link" => "",
        #: storage/themes/default/bio/edit.php:384
        #: storage/themes/default/bio/new.php:370
        "Add Tiktok" => "",
        #: storage/themes/default/bio/index.php:3
        "Bio Builder" => "",
        #: storage/themes/default/bio/index.php:23
        #: storage/themes/default/teams/edit.php:28
        #: storage/themes/default/teams/index.php:130
        "Edit Bio" => "",
        #: storage/themes/default/bio/index.php:28
        "Set as Default" => "",
        #: storage/themes/default/bio/index.php:32
        #: storage/themes/default/domains/index.php:41
        #: storage/themes/default/overlay/index.php:28
        #: storage/themes/default/partials/links.php:26
        #: storage/themes/default/pixels/index.php:26
        #: storage/themes/default/qr/index.php:28
        #: storage/themes/default/splash/index.php:30
        #: storage/themes/default/teams/index.php:29
        #: storage/themes/default/user/campaigns.php:27
        #: storage/themes/default/user/edit.php:89
        #: storage/themes/default/user/settings.php:199
        "Delete" => "",
        #: storage/themes/default/bio/index.php:36
        "Default" => "",
        #: storage/themes/default/bio/index.php:39
        #: storage/themes/default/gates/media.php:29
        #: storage/themes/default/index.php:17
        #: storage/themes/default/partials/links.php:74
        #: storage/themes/default/user/affiliate.php:12
        #: storage/themes/default/user/campaigns.php:37
        #: storage/themes/default/user/campaigns.php:43
        #: storage/themes/default/user/edit.php:245
        #: storage/themes/default/user/edit.php:248
        #: storage/themes/default/user/index.php:214
        #: storage/themes/default/user/links.php:120
        #: storage/themes/default/user/settings.php:152
        #: storage/themes/default/user/settings.php:167
        "Copy" => "",
        #: storage/themes/default/bio/index.php:42
        #: storage/themes/default/gates/media.php:14
        "Views" => "",
        #: storage/themes/default/bio/index.php:53
        #: storage/themes/default/overlay/index.php:44
        #: storage/themes/default/pixels/index.php:43
        #: storage/themes/default/qr/index.php:45
        #: storage/themes/default/splash/index.php:45
        #: storage/themes/default/user/campaigns.php:58
        "No content found. You can create some." => "",
        #: storage/themes/default/bio/index.php:64
        #: storage/themes/default/domains/index.php:56
        #: storage/themes/default/domains/new.php:42
        #: storage/themes/default/overlay/create.php:33
        #: storage/themes/default/overlay/index.php:56
        #: storage/themes/default/pixels/index.php:54
        #: storage/themes/default/pixels/new.php:49
        #: storage/themes/default/pricing/index.php:44
        #: storage/themes/default/pricing/index.php:45
        #: storage/themes/default/pricing/index.php:49
        #: storage/themes/default/pricing/index.php:50
        #: storage/themes/default/pricing/index.php:51
        #: storage/themes/default/pricing/index.php:52
        #: storage/themes/default/pricing/index.php:53
        #: storage/themes/default/pricing/index.php:54
        #: storage/themes/default/pricing/index.php:55
        #: storage/themes/default/qr/index.php:56
        #: storage/themes/default/splash/index.php:57
        #: storage/themes/default/teams/index.php:62
        #: storage/themes/default/user/billing.php:73
        #: storage/themes/default/user/billing.php:74
        #: storage/themes/default/user/billing.php:77
        #: storage/themes/default/user/billing.php:78
        #: storage/themes/default/user/billing.php:79
        #: storage/themes/default/user/billing.php:80
        #: storage/themes/default/user/billing.php:81
        #: storage/themes/default/user/billing.php:82
        #: storage/themes/default/user/billing.php:83
        "Unlimited" => "",
        #: storage/themes/default/bio/index.php:71
        "What are Bio Pages?" => "",
        #: storage/themes/default/bio/index.php:75
        "A bio page allows you to create a trackable and customizable landing page where you can add links to your social network pages." => "",
        #: storage/themes/default/bio/index.php:76
        "You can set a bio page as default and access them via your profile page." => "",
        #: storage/themes/default/bio/index.php:85
        #: storage/themes/default/domains/index.php:79
        #: storage/themes/default/overlay/create.php:53
        #: storage/themes/default/overlay/index.php:76
        #: storage/themes/default/pixels/index.php:75
        #: storage/themes/default/qr/index.php:76
        #: storage/themes/default/splash/index.php:77
        #: storage/themes/default/teams/index.php:84
        #: storage/themes/default/user/campaigns.php:156
        #: storage/themes/default/user/index.php:173
        #: storage/themes/default/user/links.php:79
        "Are you sure you want to delete this?" => "",
        #: storage/themes/default/bio/index.php:89
        #: storage/themes/default/domains/index.php:83
        #: storage/themes/default/overlay/create.php:57
        #: storage/themes/default/overlay/index.php:80
        #: storage/themes/default/pixels/index.php:79
        #: storage/themes/default/qr/index.php:80
        #: storage/themes/default/splash/index.php:81
        #: storage/themes/default/teams/index.php:88
        #: storage/themes/default/user/campaigns.php:160
        #: storage/themes/default/user/index.php:177
        #: storage/themes/default/user/links.php:83
        "You are trying to delete a record. This action is permanent and cannot be reversed." => "",
        #: storage/themes/default/bio/index.php:92
        #: storage/themes/default/domains/index.php:86
        #: storage/themes/default/layouts/dashboard.php:121
        #: storage/themes/default/overlay/create.php:60
        #: storage/themes/default/overlay/index.php:83
        #: storage/themes/default/pixels/index.php:82
        #: storage/themes/default/qr/index.php:83
        #: storage/themes/default/splash/index.php:84
        #: storage/themes/default/teams/index.php:91
        #: storage/themes/default/teams/index.php:178
        #: storage/themes/default/user/campaigns.php:108
        #: storage/themes/default/user/campaigns.php:145
        #: storage/themes/default/user/campaigns.php:163
        #: storage/themes/default/user/campaignstats.php:111
        #: storage/themes/default/user/index.php:180
        #: storage/themes/default/user/index.php:252
        #: storage/themes/default/user/links.php:86
        #: storage/themes/default/user/links.php:158
        #: storage/themes/default/user/settings.php:198
        #: storage/themes/default/user/settings.php:219
        #: storage/themes/default/user/stats.php:70
        "Cancel" => "",
        #: storage/themes/default/bio/index.php:93
        #: storage/themes/default/domains/index.php:87
        #: storage/themes/default/overlay/create.php:61
        #: storage/themes/default/overlay/index.php:84
        #: storage/themes/default/pixels/index.php:83
        #: storage/themes/default/qr/index.php:84
        #: storage/themes/default/splash/index.php:85
        #: storage/themes/default/teams/index.php:92
        #: storage/themes/default/user/campaigns.php:164
        #: storage/themes/default/user/index.php:181
        #: storage/themes/default/user/links.php:87
        "Confirm" => "",
        #: storage/themes/default/bio/new.php:20
        "Choose domain to generate the link with." => "",
        #: storage/themes/default/bio/new.php:211
        #: storage/themes/default/user/tools.php:111
        "Save" => "",
        #: storage/themes/default/blog_single.php:23
        "Published on" => "",
        #: storage/themes/default/blog_single.php:60
        "Keep reading" => "",
        #: storage/themes/default/blog_single.php:61
        "More posts from our blog" => "",
        #: storage/themes/default/blog_single.php:64
        #: storage/themes/default/user/index.php:107
        "View all" => "",
        #: storage/themes/default/class/themeSettings.php:177
        "The custom image is not valid. Only a JPG or PNG are accepted." => "",
        #: storage/themes/default/class/themeSettings.php:179
        "Custom image must be either a PNG or a JPEG (Max 500kb)." => "",
        #: storage/themes/default/class/themeSettings.php:202
        "Settings are successfully saved." => "",
        #: storage/themes/default/domains/edit.php:9
        #: storage/themes/default/domains/index.php:16
        #: storage/themes/default/domains/new.php:11
        #: storage/themes/default/partials/shortener.php:29
        #: storage/themes/default/user/edit.php:257
        "Domain" => "",
        #: storage/themes/default/domains/edit.php:15
        #: storage/themes/default/domains/index.php:17
        #: storage/themes/default/domains/new.php:18
        "Domain Root" => "",
        #: storage/themes/default/domains/edit.php:17
        #: storage/themes/default/domains/new.php:20
        "Redirects to this page if someone visits the root domain above without a short alias." => "",
        #: storage/themes/default/domains/edit.php:22
        #: storage/themes/default/domains/new.php:25
        "Domain 404" => "",
        #: storage/themes/default/domains/edit.php:24
        #: storage/themes/default/domains/new.php:27
        "Redirects to this page if a short url is not found (error 404)." => "",
        #: storage/themes/default/domains/edit.php:29
        #: storage/themes/default/teams/edit.php:75
        "Update Domain" => "",
        #: storage/themes/default/domains/index.php:6
        #: storage/themes/default/domains/new.php:32
        "Add Domain" => "",
        #: storage/themes/default/domains/index.php:18
        "404 Redirect" => "",
        #: storage/themes/default/domains/index.php:28
        #: storage/themes/default/teams/index.php:32
        #: storage/themes/default/user/billing.php:27
        #: storage/themes/default/user/campaigns.php:30
        #: storage/themes/default/user/tools.php:94
        "Active" => "",
        #: storage/themes/default/domains/index.php:30
        "Pending DNS" => "",
        #: storage/themes/default/domains/index.php:32
        "Inactive/Disabled" => "",
        #: storage/themes/default/domains/index.php:35
        #: storage/themes/default/domains/index.php:36
        #: storage/themes/default/user/index.php:243
        #: storage/themes/default/user/links.php:149
        "None" => "",
        #: storage/themes/default/domains/index.php:54
        #: storage/themes/default/domains/new.php:40
        "Domains" => "",
        #: storage/themes/default/domains/index.php:63
        #: storage/themes/default/domains/new.php:49
        "How to setup custom domain" => "",
        #: storage/themes/default/domains/index.php:67
        "If you have a custom domain name that you want to use with our service, you can associate it to your account very easily. Once added, we will add the domain to your account and set it as the default domain name for your URLs. DNS changes could take up to 36 hours. If you are planning to serve SSL on your domain name, we recommend using cloudflare." => "",
        #: storage/themes/default/domains/index.php:69
        #: storage/themes/default/domains/new.php:55
        "To point your domain name, create an A record and set the value to " => "",
        #: storage/themes/default/domains/new.php:13
        "You will need to setup a DNS record for your domain to work. See instructions on the right side." => "",
        #: storage/themes/default/domains/new.php:53
        "If you have a custom domain name that you want to use with our service, you can associate it to your account very easily. Once added, we will add the domain to your account and set it as the default domain name for your URLs. DNS changes could take up to 36 hours." => "",
        #: storage/themes/default/errors/404.php:26
        "Error" => "",
        #: storage/themes/default/errors/404.php:28
        "The page you are looking for could not be found." => "",
        #: storage/themes/default/errors/404.php:32
        #: storage/themes/default/errors/disabled.php:32
        #: storage/themes/default/errors/expired.php:31
        "Back to home" => "",
        #: storage/themes/default/errors/disabled.php:26
        "Stop" => "",
        #: storage/themes/default/errors/disabled.php:28
        "There is a problem with this link and we have blocked it either because it is potentially malicious or contains inappropriate content that is against our terms of service. We actively monitor all links on our platform to ensure the safety of all our users. If you have any questions, feel free to contact us." => "",
        #: storage/themes/default/errors/expired.php:25
        "Oops" => "",
        #: storage/themes/default/errors/expired.php:27
        "The link you are trying to access is now expired either because the campaign ended or the link was disabled. If you have any questions, feel free to contact us." => "",
        #: storage/themes/default/gates/custom.php:12
        #: storage/themes/default/splash/edit.php:72
        "View site" => "",
        #: storage/themes/default/gates/custom.php:15
        "Seconds" => "",
        #: storage/themes/default/gates/custom.php:20
        "Powered by" => "",
        #: storage/themes/default/gates/domain.php:8
        "Custom domain working" => "",
        #: storage/themes/default/gates/domain.php:9
        "Your <strong>domain name</strong> is now successfully pointed to our server. You can now start using it from the platform and shorten branded links with your own domain name." => "",
        #: storage/themes/default/gates/domain.php:10
        "If you want to display another page instead of this page when someone accesses your root domain name, you can define that link in your settings by logging in to your account. You can also define a custom 404 error page." => "",
        #: storage/themes/default/gates/domain.php:11
        "If you have any questions, please do not hesitate to contact us." => "",
        #: storage/themes/default/gates/domain.php:16
        #: storage/themes/default/pages/bio.php:13
        #: storage/themes/default/pages/qr.php:13
        "Contact us" => "",
        #: storage/themes/default/gates/frame.php:18
        "Share" => "",
        #: storage/themes/default/gates/frame.php:19
        "Tweet" => "",
        #: storage/themes/default/gates/frame.php:20
        #: storage/themes/default/layouts/dashboard.php:122
        "Close" => "",
        #: storage/themes/default/gates/media.php:26
        "Short URL" => "",
        #: storage/themes/default/gates/media.php:33
        #: storage/themes/default/gates/media.php:34
        "Share on" => "",
        #: storage/themes/default/gates/password.php:14
        "Enter Password" => "",
        #: storage/themes/default/gates/password.php:15
        "The access to this URL is restricted. Please enter your password to view it." => "",
        #: storage/themes/default/gates/password.php:31
        "Unlock" => "",
        #: storage/themes/default/gates/splash.php:13
        "You are about to be redirected to another page." => "",
        #: storage/themes/default/gates/splash.php:24
        "Redirect me" => "",
        #: storage/themes/default/gates/splash.php:27
        "Take me to your homepage" => "",
        #: storage/themes/default/gates/splash.php:32
        "You are about to be redirected to another page. We are not responsible for the content of that page or the consequences it may have on you." => "",
        #: storage/themes/default/index.php:15
        "Paste a long url" => "",
        #: storage/themes/default/index.php:18
        #: storage/themes/default/partials/shortener.php:18
        "Shorten" => "",
        #: storage/themes/default/index.php:22
        "Advanced" => "",
        #: storage/themes/default/index.php:26
        #: storage/themes/default/partials/shortener.php:60
        #: storage/themes/default/user/edit.php:290
        "Custom" => "",
        #: storage/themes/default/index.php:27
        #: storage/themes/default/partials/shortener.php:64
        #: storage/themes/default/user/edit.php:293
        "Type your custom alias here" => "",
        #: storage/themes/default/index.php:32
        #: storage/themes/default/partials/shortener.php:71
        #: storage/themes/default/user/edit.php:298
        "Password Protection" => "",
        #: storage/themes/default/index.php:33
        #: storage/themes/default/partials/shortener.php:75
        #: storage/themes/default/user/edit.php:301
        "Type your password here" => "",
        #: storage/themes/default/index.php:43
        "Your link has been successfully shortened. Want to more customization options?" => "",
        #: storage/themes/default/index.php:44
        "Get started" => "",
        #: storage/themes/default/index.php:49
        "Integrations" => "",
        #: storage/themes/default/index.php:106
        "Your latest links" => "",
        #: storage/themes/default/index.php:114
        "Want more options to customize the link, QR codes, branding and advanced metrics?" => "",
        #: storage/themes/default/index.php:137
        "Latest links" => "",
        #: storage/themes/default/index.php:156
        "One short link, infinite possibilities." => "",
        #: storage/themes/default/index.php:159
        "A short link is a powerful marketing tool when you use it carefully. It is not just a link but a medium between your customer and their destination. A short link allows you to collect so much data about your customers and their behaviors." => "",
        #: storage/themes/default/index.php:173
        "Smart Targeting" => "",
        #: storage/themes/default/index.php:175
        "Target your customers to increase your reach and redirect them to a relevant page. Add a pixel to retarget them in your social media ad campaign to capture them." => "",
        #: storage/themes/default/index.php:190
        "In-Depth Analytics" => "",
        #: storage/themes/default/index.php:192
        "Share your links to your network and measure data to optimize your marketing campaign's performance. Reach an audience that fits your needs." => "",
        #: storage/themes/default/index.php:207
        "Digital Experience" => "",
        #: storage/themes/default/index.php:209
        "Use various powerful tools increase conversion and provide a non-intrusive experience to your customers without disengaging them." => "",
        #: storage/themes/default/index.php:223 storage/themes/default/index.php:269
        "Perfect for sales & marketing" => "",
        #: storage/themes/default/index.php:225 storage/themes/default/index.php:402
        "Understanding your users and customers will help you increase your conversion. Our system allows you to track everything. Whether it is the amount of clicks, the country or the referrer, the data is there for you to analyze it." => "",
        #: storage/themes/default/index.php:236
        "Redirection Tools" => "",
        #: storage/themes/default/index.php:248
        "Powerful Statistics" => "",
        #: storage/themes/default/index.php:260
        "Beautiful Profiles" => "",
        #: storage/themes/default/index.php:278 storage/themes/default/index.php:324
        "Powerful tools that work" => "",
        #: storage/themes/default/index.php:280
        "Our product lets your target your users to better understand their behavior and provide them a better overall experience through smart re-targeting. We provide you many powerful tools to reach them better." => "",
        #: storage/themes/default/index.php:291
        #: storage/themes/default/partials/sidebar_menu.php:26
        "Link Management" => "",
        #: storage/themes/default/index.php:303
        "Privacy Control" => "",
        #: storage/themes/default/index.php:315
        "Powerful Dashboard" => "",
        #: storage/themes/default/index.php:341 storage/themes/default/index.php:345
        "New York, United States" => "",
        #: storage/themes/default/index.php:343 storage/themes/default/index.php:363
        #: storage/themes/default/index.php:383
        "Someone visited your link" => "",
        #: storage/themes/default/index.php:351 storage/themes/default/index.php:371
        #: storage/themes/default/index.php:391
        "{d} minutes ago" => "",
        #: storage/themes/default/index.php:361 storage/themes/default/index.php:365
        "Paris, France" => "",
        #: storage/themes/default/index.php:381 storage/themes/default/index.php:385
        "London, United Kingdom" => "",
        #: storage/themes/default/index.php:400
        "Optimize your marketing strategy" => "",
        #: storage/themes/default/index.php:413
        "More features than asked for" => "",
        #: storage/themes/default/index.php:426
        "Custom Landing Page" => "",
        #: storage/themes/default/index.php:428
        "Create a custom landing page to promote your product or service on forefront and engage the user in your marketing campaign." => "",
        #: storage/themes/default/index.php:443
        "CTA Overlays" => "",
        #: storage/themes/default/index.php:445
        "Use our overlay tool to display unobtrusive notifications, polls or even a contact on the target website. Great for campaigns." => "",
        #: storage/themes/default/index.php:460
        #: storage/themes/default/pricing/index.php:53
        #: storage/themes/default/user/billing.php:81
        "Event Tracking" => "",
        #: storage/themes/default/index.php:462
        "Add your custom pixel from providers such as Facebook and track events right when they are happening." => "",
        #: storage/themes/default/index.php:477
        "Team Management" => "",
        #: storage/themes/default/index.php:479
        "Invite your team members and assign them specific privileges to manage links, bundles, pages and other features." => "",
        #: storage/themes/default/index.php:494
        "Branded Domain Names" => "",
        #: storage/themes/default/index.php:496
        "Easily add your own domain name for short your links and take control of your brand name and your users' trust." => "",
        #: storage/themes/default/index.php:511
        "Robust API" => "",
        #: storage/themes/default/index.php:513
        "Use our powerful API to build custom applications or extend your own application with our powerful tools." => "",
        #: storage/themes/default/index.php:532
        "What our customers say about us" => "",
        #: storage/themes/default/index.php:565
        "Powering" => "",
        #: storage/themes/default/index.php:575
        "Serving" => "",
        #: storage/themes/default/index.php:585
        "Trusted by" => "",
        #: storage/themes/default/index.php:590
        "Happy Customers" => "",
        #: storage/themes/default/invoice.php:1 storage/themes/default/invoice.php:25
        "Invoice" => "",
        #: storage/themes/default/invoice.php:29
        "Payment Date" => "",
        #: storage/themes/default/invoice.php:38
        "Bill to" => "",
        #: storage/themes/default/invoice.php:49
        "Payment To" => "",
        #: storage/themes/default/invoice.php:57
        #: storage/themes/default/overlay/create_newsletter.php:111
        #: storage/themes/default/overlay/edit_newsletter.php:111
        #: storage/themes/default/pages/api.php:162
        #: storage/themes/default/partials/shortener.php:93
        #: storage/themes/default/user/edit.php:312
        "Description" => "",
        #: storage/themes/default/invoice.php:64
        "Subscription" => "",
        #: storage/themes/default/invoice.php:70
        #: storage/themes/default/overlay/edit_poll.php:127
        #: storage/themes/default/pricing/checkout.php:116
        "Total" => "",
        #: storage/themes/default/layouts/dashboard.php:70
        #: storage/themes/default/partials/footer.php:60
        #: storage/themes/default/partials/main_menu.php:27
        #: storage/themes/default/partials/sidebar_menu.php:92
        #: storage/themes/default/pricing/index.php:60
        #: storage/themes/default/teams/edit.php:67
        #: storage/themes/default/teams/index.php:169
        #: storage/themes/default/user/billing.php:86
        "Developer API" => "",
        #: storage/themes/default/layouts/dashboard.php:75
        #: storage/themes/default/partials/footer.php:86
        "Report" => "",
        #: storage/themes/default/layouts/dashboard.php:80
        #: storage/themes/default/user/affiliate.php:69
        "Contact" => "",
        #: storage/themes/default/layouts/dashboard.php:108
        "The selected image is not valid. Please select a jpg or png with a maximum size of 1mb" => "",
        #: storage/themes/default/layouts/dashboard.php:111
        #: storage/themes/default/layouts/main.php:58
        "This website uses cookies to ensure you get the best experience on our website." => "",
        #: storage/themes/default/layouts/dashboard.php:112
        #: storage/themes/default/layouts/main.php:59
        "Got it!" => "",
        #: storage/themes/default/layouts/dashboard.php:113
        #: storage/themes/default/layouts/main.php:60
        #: storage/themes/default/overlay/create_message.php:49
        #: storage/themes/default/overlay/create_message.php:121
        #: storage/themes/default/overlay/edit_message.php:49
        "Learn more" => "",
        #: storage/themes/default/layouts/dashboard.php:114
        #: storage/themes/default/layouts/main.php:62
        "The coupon enter is not valid" => "",
        #: storage/themes/default/layouts/dashboard.php:115
        #: storage/themes/default/layouts/main.php:63
        "You must select at least 1 url." => "",
        #: storage/themes/default/layouts/dashboard.php:117
        #: storage/themes/default/layouts/main.php:65
        "No data is available for this request." => "",
        #: storage/themes/default/layouts/dashboard.php:119
        "Are you sure you want to proceed?" => "",
        #: storage/themes/default/layouts/dashboard.php:120
        "Proceed" => "",
        #: storage/themes/default/layouts/dashboard.php:123
        "Note that this action is permanent. Once you click proceed, you <strong>may not undo</strong> this. Click anywhere outside this modal or click <a href='#close' class='close-modal'>close</a> to close this." => "",
        #: storage/themes/default/maintenance.php:8
        "BRB" => "",
        #: storage/themes/default/maintenance.php:10
        "We are currently offline for maintenance. We will be back online as soon as we are done. It should not take long." => "",
        #: storage/themes/default/overlay/create.php:19
        #: storage/themes/default/overlay/create_contact.php:151
        #: storage/themes/default/overlay/create_image.php:67
        #: storage/themes/default/overlay/create_message.php:110
        #: storage/themes/default/overlay/create_newsletter.php:104
        #: storage/themes/default/overlay/create_poll.php:101
        #: storage/themes/default/overlay/edit_image.php:67
        #: storage/themes/default/splash/create.php:58
        "Create" => "",
        #: storage/themes/default/overlay/create.php:40
        #: storage/themes/default/overlay/index.php:63
        "What is a CTA overlay?" => "",
        #: storage/themes/default/overlay/create.php:44
        #: storage/themes/default/overlay/index.php:67
        "An overlay page allows you to display a small non-intrusive overlay on the destination website to advertise your product or your services. You can also use this feature to send a message to your users. You can customize the message and the appearance of the overlay right from this page. As soon as you save it, the changes will be applied immediately across all your URLs using this type. Please note that some secured and sensitive websites such as google.com or facebook.com do not work with this feature. You can have unlimited overlay pages and you can choose one for each URL." => "",
        #: storage/themes/default/overlay/create_contact.php:18
        #: storage/themes/default/overlay/edit_contact.php:18
        "Send Email Address" => "",
        #: storage/themes/default/overlay/create_contact.php:19
        #: storage/themes/default/overlay/edit_contact.php:19
        "Emails from the form will be sent to this address" => "",
        #: storage/themes/default/overlay/create_contact.php:26
        #: storage/themes/default/overlay/edit_contact.php:26
        "Email Subject" => "",
        #: storage/themes/default/overlay/create_contact.php:27
        #: storage/themes/default/overlay/edit_contact.php:27
        "Something you would know where it comes from." => "",
        #: storage/themes/default/overlay/create_contact.php:32
        #: storage/themes/default/overlay/create_newsletter.php:18
        #: storage/themes/default/overlay/edit_contact.php:32
        #: storage/themes/default/overlay/edit_newsletter.php:18
        "Form Label" => "",
        #: storage/themes/default/overlay/create_contact.php:32
        #: storage/themes/default/overlay/create_contact.php:40
        #: storage/themes/default/overlay/create_contact.php:46
        #: storage/themes/default/overlay/create_message.php:33
        #: storage/themes/default/overlay/create_message.php:41
        #: storage/themes/default/overlay/create_message.php:48
        #: storage/themes/default/overlay/create_newsletter.php:18
        #: storage/themes/default/overlay/create_newsletter.php:26
        #: storage/themes/default/overlay/create_newsletter.php:32
        #: storage/themes/default/overlay/create_poll.php:53
        #: storage/themes/default/overlay/edit_message.php:33
        #: storage/themes/default/overlay/edit_message.php:41
        #: storage/themes/default/overlay/edit_message.php:48
        #: storage/themes/default/overlay/edit_newsletter.php:18
        #: storage/themes/default/overlay/edit_newsletter.php:26
        #: storage/themes/default/overlay/edit_newsletter.php:32
        #: storage/themes/default/overlay/edit_poll.php:52
        "leave empty to disable" => "",
        #: storage/themes/default/overlay/create_contact.php:33
        #: storage/themes/default/overlay/create_newsletter.php:19
        #: storage/themes/default/overlay/edit_contact.php:33
        #: storage/themes/default/overlay/edit_newsletter.php:19
        "e.g. Need help?" => "",
        #: storage/themes/default/overlay/create_contact.php:40
        #: storage/themes/default/overlay/create_newsletter.php:26
        #: storage/themes/default/overlay/edit_contact.php:40
        #: storage/themes/default/overlay/edit_newsletter.php:26
        "Form Description" => "",
        #: storage/themes/default/overlay/create_contact.php:41
        #: storage/themes/default/overlay/create_newsletter.php:27
        #: storage/themes/default/overlay/edit_contact.php:41
        #: storage/themes/default/overlay/edit_newsletter.php:27
        "(optional) Provide a description or anything you want to add to the form." => "",
        #: storage/themes/default/overlay/create_contact.php:46
        #: storage/themes/default/overlay/create_newsletter.php:32
        #: storage/themes/default/overlay/create_poll.php:53
        #: storage/themes/default/overlay/edit_contact.php:46
        #: storage/themes/default/overlay/edit_newsletter.php:32
        #: storage/themes/default/overlay/edit_poll.php:52
        "Thank You Message" => "",
        #: storage/themes/default/overlay/create_contact.php:47
        #: storage/themes/default/overlay/edit_contact.php:47
        "e.g. Thank you. We will respond asap." => "",
        #: storage/themes/default/overlay/create_contact.php:55
        #: storage/themes/default/overlay/create_newsletter.php:41
        #: storage/themes/default/overlay/create_poll.php:41
        #: storage/themes/default/overlay/edit_contact.php:55
        #: storage/themes/default/overlay/edit_contact.php:58
        #: storage/themes/default/overlay/edit_newsletter.php:41
        #: storage/themes/default/overlay/edit_poll.php:40
        "Text Labels" => "",
        #: storage/themes/default/overlay/create_contact.php:61
        #: storage/themes/default/overlay/edit_contact.php:62
        "Name Placeholder" => "",
        #: storage/themes/default/overlay/create_contact.php:63
        #: storage/themes/default/overlay/create_contact.php:70
        #: storage/themes/default/overlay/create_contact.php:77
        #: storage/themes/default/overlay/create_contact.php:84
        #: storage/themes/default/overlay/create_newsletter.php:49
        #: storage/themes/default/overlay/edit_contact.php:64
        #: storage/themes/default/overlay/edit_contact.php:71
        #: storage/themes/default/overlay/edit_contact.php:78
        #: storage/themes/default/overlay/edit_contact.php:85
        #: storage/themes/default/overlay/edit_newsletter.php:49
        "If you want to use a different language, change these." => "",
        #: storage/themes/default/overlay/create_contact.php:68
        #: storage/themes/default/overlay/edit_contact.php:69
        "Email Placeholder" => "",
        #: storage/themes/default/overlay/create_contact.php:75
        #: storage/themes/default/overlay/edit_contact.php:76
        "Message Placeholder" => "",
        #: storage/themes/default/overlay/create_contact.php:82
        #: storage/themes/default/overlay/edit_contact.php:83
        "Send Button Placeholder" => "",
        #: storage/themes/default/overlay/create_contact.php:83
        #: storage/themes/default/overlay/create_contact.php:172
        #: storage/themes/default/pages/contact.php:35
        #: storage/themes/default/pages/report.php:40
        "Send" => "",
        #: storage/themes/default/overlay/create_contact.php:92
        #: storage/themes/default/overlay/create_image.php:44
        #: storage/themes/default/overlay/create_message.php:57
        #: storage/themes/default/overlay/create_newsletter.php:57
        #: storage/themes/default/overlay/create_poll.php:62
        #: storage/themes/default/overlay/edit_contact.php:93
        #: storage/themes/default/overlay/edit_image.php:44
        #: storage/themes/default/overlay/edit_message.php:57
        #: storage/themes/default/overlay/edit_newsletter.php:57
        #: storage/themes/default/overlay/edit_poll.php:61
        "Appearance Customization" => "",
        #: storage/themes/default/overlay/create_contact.php:98
        #: storage/themes/default/overlay/edit_contact.php:99
        "Form Background Color" => "",
        #: storage/themes/default/overlay/create_contact.php:104
        #: storage/themes/default/overlay/edit_contact.php:105
        "Form Text Color" => "",
        #: storage/themes/default/overlay/create_contact.php:110
        #: storage/themes/default/overlay/edit_contact.php:111
        "Input Background Color" => "",
        #: storage/themes/default/overlay/create_contact.php:116
        #: storage/themes/default/overlay/edit_contact.php:117
        "Input Text Color" => "",
        #: storage/themes/default/overlay/create_contact.php:122
        #: storage/themes/default/overlay/create_message.php:87
        #: storage/themes/default/overlay/create_newsletter.php:75
        #: storage/themes/default/overlay/create_poll.php:80
        #: storage/themes/default/overlay/edit_contact.php:123
        #: storage/themes/default/overlay/edit_message.php:87
        #: storage/themes/default/overlay/edit_newsletter.php:75
        #: storage/themes/default/overlay/edit_poll.php:79
        "Button Background Color" => "",
        #: storage/themes/default/overlay/create_contact.php:128
        #: storage/themes/default/overlay/create_message.php:93
        #: storage/themes/default/overlay/create_newsletter.php:81
        #: storage/themes/default/overlay/create_poll.php:86
        #: storage/themes/default/overlay/edit_contact.php:129
        #: storage/themes/default/overlay/edit_message.php:93
        #: storage/themes/default/overlay/edit_newsletter.php:81
        #: storage/themes/default/overlay/edit_poll.php:85
        "Button Text Color" => "",
        #: storage/themes/default/overlay/create_contact.php:134
        #: storage/themes/default/overlay/create_image.php:56
        #: storage/themes/default/overlay/create_message.php:99
        #: storage/themes/default/overlay/create_newsletter.php:87
        #: storage/themes/default/overlay/create_poll.php:92
        #: storage/themes/default/overlay/edit_contact.php:135
        #: storage/themes/default/overlay/edit_image.php:56
        #: storage/themes/default/overlay/edit_message.php:99
        #: storage/themes/default/overlay/edit_newsletter.php:87
        #: storage/themes/default/overlay/edit_poll.php:91
        "Overlay Position" => "",
        #: storage/themes/default/overlay/create_contact.php:136
        #: storage/themes/default/overlay/create_image.php:58
        #: storage/themes/default/overlay/create_message.php:101
        #: storage/themes/default/overlay/create_newsletter.php:89
        #: storage/themes/default/overlay/edit_contact.php:137
        #: storage/themes/default/overlay/edit_image.php:58
        #: storage/themes/default/overlay/edit_message.php:101
        #: storage/themes/default/overlay/edit_newsletter.php:89
        "Top Left" => "",
        #: storage/themes/default/overlay/create_contact.php:137
        #: storage/themes/default/overlay/create_image.php:59
        #: storage/themes/default/overlay/create_message.php:102
        #: storage/themes/default/overlay/create_newsletter.php:90
        #: storage/themes/default/overlay/edit_contact.php:138
        #: storage/themes/default/overlay/edit_image.php:59
        #: storage/themes/default/overlay/edit_message.php:102
        #: storage/themes/default/overlay/edit_newsletter.php:90
        "Top Right" => "",
        #: storage/themes/default/overlay/create_contact.php:138
        #: storage/themes/default/overlay/create_image.php:60
        #: storage/themes/default/overlay/create_message.php:103
        #: storage/themes/default/overlay/create_newsletter.php:91
        #: storage/themes/default/overlay/create_poll.php:94
        #: storage/themes/default/overlay/edit_contact.php:139
        #: storage/themes/default/overlay/edit_image.php:60
        #: storage/themes/default/overlay/edit_message.php:103
        #: storage/themes/default/overlay/edit_newsletter.php:91
        #: storage/themes/default/overlay/edit_poll.php:93
        "Bottom Left" => "",
        #: storage/themes/default/overlay/create_contact.php:139
        #: storage/themes/default/overlay/create_image.php:61
        #: storage/themes/default/overlay/create_message.php:104
        #: storage/themes/default/overlay/create_newsletter.php:92
        #: storage/themes/default/overlay/create_poll.php:95
        #: storage/themes/default/overlay/edit_contact.php:140
        #: storage/themes/default/overlay/edit_image.php:61
        #: storage/themes/default/overlay/edit_message.php:104
        #: storage/themes/default/overlay/edit_newsletter.php:92
        #: storage/themes/default/overlay/edit_poll.php:94
        "Bottom Right" => "",
        #: storage/themes/default/overlay/create_contact.php:140
        #: storage/themes/default/overlay/create_image.php:62
        #: storage/themes/default/overlay/create_message.php:105
        #: storage/themes/default/overlay/create_newsletter.php:93
        #: storage/themes/default/overlay/create_poll.php:96
        #: storage/themes/default/overlay/edit_contact.php:141
        #: storage/themes/default/overlay/edit_image.php:62
        #: storage/themes/default/overlay/edit_message.php:105
        #: storage/themes/default/overlay/edit_newsletter.php:93
        #: storage/themes/default/overlay/edit_poll.php:95
        "Bottom Center" => "",
        #: storage/themes/default/overlay/create_contact.php:145
        #: storage/themes/default/overlay/create_contact.php:177
        #: storage/themes/default/overlay/create_newsletter.php:98
        #: storage/themes/default/overlay/create_newsletter.php:124
        #: storage/themes/default/overlay/edit_contact.php:146
        #: storage/themes/default/overlay/edit_contact.php:178
        #: storage/themes/default/overlay/edit_newsletter.php:98
        #: storage/themes/default/overlay/edit_newsletter.php:133
        "Webhook Notification" => "",
        #: storage/themes/default/overlay/create_contact.php:147
        #: storage/themes/default/overlay/create_newsletter.php:100
        #: storage/themes/default/overlay/edit_contact.php:148
        #: storage/themes/default/overlay/edit_newsletter.php:100
        "If you want to receive a notification directly to your app, add the url to your app's handler and as soon as there is a submission, we will send a notification to this url as well as an email to the address provided above." => "",
        #: storage/themes/default/overlay/create_contact.php:180
        #: storage/themes/default/overlay/edit_contact.php:181
        "If you add a webhook url, we will send a notification to that url with the contact form data. You will be able to integrate it with your own app or a third-party app. Below is a sample data that will be sent in <code>JSON</code> format via a <code>POST</code> request." => "",
        #: storage/themes/default/overlay/create_image.php:20
        #: storage/themes/default/overlay/edit_image.php:20
        "If you add a link here, the whole overlay will be linked to this when clicked." => "",
        #: storage/themes/default/overlay/create_image.php:27
        #: storage/themes/default/overlay/create_message.php:18
        #: storage/themes/default/overlay/edit_image.php:27
        #: storage/themes/default/overlay/edit_message.php:18
        #: storage/themes/default/qr/edit.php:306
        "Logo" => "",
        #: storage/themes/default/overlay/create_image.php:29
        #: storage/themes/default/overlay/create_message.php:20
        #: storage/themes/default/overlay/edit_image.php:29
        #: storage/themes/default/overlay/edit_message.php:20
        "Logo should be square with a maximum size of 100x100. To remove the image, click on the upload field and then cancel it." => "",
        #: storage/themes/default/overlay/create_image.php:34
        #: storage/themes/default/overlay/edit_image.php:34
        "Background Image" => "",
        #: storage/themes/default/overlay/create_image.php:36
        #: storage/themes/default/overlay/edit_image.php:36
        "Image should be rectangle with a maximum size of 600x150. To remove the image, click on the upload field and then cancel it." => "",
        #: storage/themes/default/overlay/create_image.php:50
        #: storage/themes/default/overlay/create_message.php:63
        #: storage/themes/default/overlay/create_newsletter.php:63
        #: storage/themes/default/overlay/create_poll.php:68
        #: storage/themes/default/overlay/edit_image.php:50
        #: storage/themes/default/overlay/edit_message.php:63
        #: storage/themes/default/overlay/edit_newsletter.php:63
        #: storage/themes/default/overlay/edit_poll.php:67
        "Overlay Background Color" => "",
        #: storage/themes/default/overlay/create_message.php:27
        #: storage/themes/default/overlay/edit_message.php:27
        #: storage/themes/default/splash/create.php:51
        #: storage/themes/default/splash/edit.php:51
        "Custom Message" => "",
        #: storage/themes/default/overlay/create_message.php:28
        #: storage/themes/default/overlay/edit_message.php:28
        #: storage/themes/default/splash/create.php:52
        #: storage/themes/default/splash/edit.php:52
        "Get a $10 discount with any purchase more than $50" => "",
        #: storage/themes/default/overlay/create_message.php:33
        #: storage/themes/default/overlay/edit_message.php:33
        "Overlay label" => "",
        #: storage/themes/default/overlay/create_message.php:41
        #: storage/themes/default/overlay/edit_message.php:41
        "Button Link" => "",
        #: storage/themes/default/overlay/create_message.php:43
        #: storage/themes/default/overlay/edit_message.php:43
        "If you remove the button text below but add a link here, the whole overlay will be linked to this when clicked." => "",
        #: storage/themes/default/overlay/create_message.php:48
        #: storage/themes/default/overlay/edit_message.php:48
        "Button Text" => "",
        #: storage/themes/default/overlay/create_message.php:69
        #: storage/themes/default/overlay/create_newsletter.php:69
        #: storage/themes/default/overlay/create_poll.php:74
        #: storage/themes/default/overlay/edit_message.php:69
        #: storage/themes/default/overlay/edit_newsletter.php:69
        #: storage/themes/default/overlay/edit_poll.php:73
        "Overlay Text Color" => "",
        #: storage/themes/default/overlay/create_message.php:75
        #: storage/themes/default/overlay/edit_message.php:75
        "Label Background Color" => "",
        #: storage/themes/default/overlay/create_message.php:81
        #: storage/themes/default/overlay/edit_message.php:81
        "Label Text Color" => "",
        #: storage/themes/default/overlay/create_message.php:116
        "Promo" => "",
        #: storage/themes/default/overlay/create_message.php:120
        "Your text here" => "",
        #: storage/themes/default/overlay/create_newsletter.php:33
        #: storage/themes/default/overlay/edit_newsletter.php:33
        "e.g. Thank you." => "",
        #: storage/themes/default/overlay/create_newsletter.php:47
        #: storage/themes/default/overlay/edit_newsletter.php:47
        "Button" => "",
        #: storage/themes/default/overlay/create_newsletter.php:48
        #: storage/themes/default/overlay/create_newsletter.php:117
        "Subscribe" => "",
        #: storage/themes/default/overlay/create_newsletter.php:110
        #: storage/themes/default/overlay/edit_newsletter.php:110
        #: storage/themes/default/user/settings.php:125
        "Newsletter" => "",
        #: storage/themes/default/overlay/create_newsletter.php:127
        #: storage/themes/default/overlay/edit_newsletter.php:136
        "If you add a webhook url, we will send a notification to that url with the form data. You will be able to integrate it with your own app or a third-party app. Below is a sample data that will be sent in <code>JSON</code> format via a <code>POST</code> request." => "",
        #: storage/themes/default/overlay/create_poll.php:20
        #: storage/themes/default/overlay/edit_poll.php:20
        "Question" => "",
        #: storage/themes/default/overlay/create_poll.php:21
        #: storage/themes/default/overlay/edit_poll.php:21
        "e.g. What is your favorite color?" => "",
        #: storage/themes/default/overlay/create_poll.php:26
        #: storage/themes/default/overlay/edit_poll.php:26
        "Options" => "",
        #: storage/themes/default/overlay/create_poll.php:27
        #: storage/themes/default/overlay/edit_poll.php:27
        "You can add up to 10 options for each poll. To add an extra option click Add Option above. To ignore a field, leave it empty." => "",
        #: storage/themes/default/overlay/create_poll.php:36
        #: storage/themes/default/overlay/edit_poll.php:35
        "Add Option" => "",
        #: storage/themes/default/overlay/create_poll.php:47
        #: storage/themes/default/overlay/edit_poll.php:46
        "Vote Button Placeholder" => "",
        #: storage/themes/default/overlay/create_poll.php:54
        "Thanks..." => "",
        #: storage/themes/default/overlay/create_poll.php:107
        "Your question here?" => "",
        #: storage/themes/default/overlay/edit_contact.php:32
        #: storage/themes/default/overlay/edit_contact.php:40
        #: storage/themes/default/overlay/edit_contact.php:46
        "(leave empty to disable)" => "",
        #: storage/themes/default/overlay/edit_newsletter.php:124
        "Newsletter Emails" => "",
        #: storage/themes/default/overlay/edit_newsletter.php:127
        "Collected {c} emails in total" => "",
        #: storage/themes/default/overlay/edit_newsletter.php:128
        "Download as CSV" => "",
        #: storage/themes/default/overlay/edit_poll.php:117
        "Poll Results" => "",
        #: storage/themes/default/pages/affiliate.php:6
        "Earn {p} commission on affiliate sales" => "",
        #: storage/themes/default/pages/affiliate.php:7
        #, php-format
        "Refer customers to us and we will reward you a {p}% commission on all qualifying sales made on our website. Anyone can join the affiliate program." => "",
        #: storage/themes/default/pages/affiliate.php:9
        "View Affiliate Portal" => "",
        #: storage/themes/default/pages/affiliate.php:11
        "Join now" => "",
        #: storage/themes/default/pages/api.php:8
        #: storage/themes/default/pages/api.php:51
        "Getting Started" => "",
        #: storage/themes/default/pages/api.php:14
        #: storage/themes/default/pages/api.php:72
        "Authentication" => "",
        #: storage/themes/default/pages/api.php:20
        #: storage/themes/default/pages/api.php:114
        "Rate Limit" => "",
        #: storage/themes/default/pages/api.php:26
        #: storage/themes/default/pages/api.php:131
        "Response Handling" => "",
        #: storage/themes/default/pages/api.php:54
        "An API key is required for requests to be processed by the system. Once a user registers, an API key is automatically generated for this user. The API key must be sent with each request (see full example below). If the API key is not sent or is expired, there will be an error. Please make sure to keep your API key secret to prevent abuse." => "",
        #: storage/themes/default/pages/api.php:60
        "Your API key" => "",
        #: storage/themes/default/pages/api.php:62
        "Regenerate API Key" => "",
        #: storage/themes/default/pages/api.php:62
        "If you proceed, your current applications will not work anymore. You will need to change your api key for it to work again." => "",
        #: storage/themes/default/pages/api.php:62
        #: storage/themes/default/user/settings.php:168
        #: storage/themes/default/user/settings.php:220
        "Regenerate" => "",
        #: storage/themes/default/pages/api.php:75
        "To authenticate with the API system, you need to send your API key as an authorization token with each request. You can see sample code below." => "",
        #: storage/themes/default/pages/api.php:117
        "Our API has a rate limiter to safeguard against spike in requests to maximize its stability. Our rate limiter is currently caped at {x} requests per {y} minute." => "",
        #: storage/themes/default/pages/api.php:119
        "Several headers will be sent alongside the response and these can be examined to determine various information about the request." => "",
        #: storage/themes/default/pages/api.php:134
        "All API response are returned in JSON format by default. To convert this into usable data, the appropriate function will need to be used according to the language. In PHP, the function json_decode() can be used to convert the data to either an object (default) or an array (set the second parameter to true). It is very important to check the error key as that provides information on whether there was an error or not. You can also check the header code." => "",
        #: storage/themes/default/pages/api.php:162
        "Parameter" => "",
        #: storage/themes/default/pages/api.php:216
        "Server response" => "",
        #: storage/themes/default/pages/bio.php:42
        "One link to rule them all" => "",
        #: storage/themes/default/pages/bio.php:44
        "Create beautiful profiles and add content like links, donation, videos and more for your social media users. Share a single on your social media profiles so your users can easily find all of your important links on a single page." => "",
        #: storage/themes/default/pages/bio.php:51
        #: storage/themes/default/pages/qr.php:25
        #: storage/themes/default/pages/qr.php:34
        "The new standard" => "",
        #: storage/themes/default/pages/bio.php:60
        "Track and optimize" => "",
        #: storage/themes/default/pages/bio.php:62
        "Profiles are fully trackable and you can find out exactly how many people have visited your profiles or clicked links on your profile and where they are from." => "",
        #: storage/themes/default/pages/bio.php:69
        #: storage/themes/default/pages/qr.php:43
        #: storage/themes/default/pages/qr.php:52
        "Trackable to the dot" => "",
        #: storage/themes/default/pages/contact.php:7
        #: storage/themes/default/pages/contact.php:30
        "If you have any questions, feel free to contact us so we can help you" => "",
        #: storage/themes/default/pages/contact.php:22
        "Please enter a valid name." => "",
        #: storage/themes/default/pages/contact.php:30
        "The message is empty or too short." => "",
        #: storage/themes/default/pages/faq.php:52
        "Back to top" => "",
        #: storage/themes/default/pages/index.php:14
        "Last Updated" => "",
        #: storage/themes/default/pages/qr.php:27
        "QR Codes are everywhere and they are not going away. They are a great asset to your company because you can easily capture users and convert them. QR codes can be customized to match your company, brand or product." => "",
        #: storage/themes/default/pages/qr.php:45
        "The beautify of QR codes is that almost any type of data can be encoded in them. Most types of data can be tracked very easily so you will know exactly when and from where a person scanned your QR code." => "",
        #: storage/themes/default/pages/report.php:6
        "Report link" => "",
        #: storage/themes/default/pages/report.php:7
        "Please report a link that you consider risky or dangerous. We will review all cases and take measure to remove the link." => "",
        #: storage/themes/default/pages/report.php:25
        #: storage/themes/default/user/index.php:210
        #: storage/themes/default/user/links.php:116
        "Short Link" => "",
        #: storage/themes/default/pages/report.php:26
        "Please enter a valid short link" => "",
        #: storage/themes/default/pages/report.php:29
        "Reason" => "",
        #: storage/themes/default/pages/report.php:31
        "Spam" => "",
        #: storage/themes/default/pages/report.php:32
        "Fraudulent" => "",
        #: storage/themes/default/pages/report.php:33
        "Malicious" => "",
        #: storage/themes/default/pages/report.php:34
        "Phishing" => "",
        #: storage/themes/default/partials/footer.php:8
        "Marketing with confidence." => "",
        #: storage/themes/default/partials/footer.php:43
        #: storage/themes/default/partials/main_menu.php:11
        #: storage/themes/default/partials/main_menu.php:52
        "Solutions" => "",
        #: storage/themes/default/partials/footer.php:53
        "Company" => "",
        #: storage/themes/default/partials/footer.php:58
        #: storage/themes/default/partials/main_menu.php:41
        #: storage/themes/default/partials/topbar_menu.php:64
        "Help" => "",
        #: storage/themes/default/partials/links.php:6
        "More Info" => "",
        #: storage/themes/default/partials/links.php:11
        "Unarchive" => "",
        #: storage/themes/default/partials/links.php:13
        "Archive" => "",
        #: storage/themes/default/partials/links.php:16
        "Set Private" => "",
        #: storage/themes/default/partials/links.php:18
        "Set Public" => "",
        #: storage/themes/default/partials/links.php:22
        #: storage/themes/default/user/edit.php:8
        "Export Statistics" => "",
        #: storage/themes/default/partials/links.php:36
        "Disabled" => "",
        #: storage/themes/default/partials/links.php:39
        "Archived" => "",
        #: storage/themes/default/partials/links.php:42
        "Public" => "",
        #: storage/themes/default/partials/links.php:45
        "Campaign" => "",
        #: storage/themes/default/partials/links.php:48
        "Geo Targeted" => "",
        #: storage/themes/default/partials/links.php:51
        "Device Targeted" => "",
        #: storage/themes/default/partials/links.php:54
        "Protected" => "",
        #: storage/themes/default/partials/links.php:57
        "Expiry on" => "",
        #: storage/themes/default/partials/links.php:57
        #: storage/themes/default/user/billing.php:46
        #: storage/themes/default/user/billing.php:68
        "Expiration" => "",
        #: storage/themes/default/partials/links.php:60
        #: storage/themes/default/partials/shortener.php:112
        #: storage/themes/default/pixels/index.php:52
        #: storage/themes/default/pixels/new.php:47
        "Pixels" => "",
        #: storage/themes/default/partials/links.php:63
        "Note" => "",
        #: storage/themes/default/partials/links.php:66
        #: storage/themes/default/partials/shortener.php:115
        "Parameters" => "",
        #: storage/themes/default/partials/links.php:72
        #: storage/themes/default/stats/partial.php:40
        "Unique Clicks" => "",
        #: storage/themes/default/partials/main_menu.php:3
        "Home" => "",
        #: storage/themes/default/partials/main_menu.php:7
        "Pricing" => "",
        #: storage/themes/default/partials/main_menu.php:17
        "Resources" => "",
        #: storage/themes/default/partials/main_menu.php:28
        "Guide on how to use our API" => "",
        #: storage/themes/default/partials/main_menu.php:42
        "Check out our frequently asked questions" => "",
        #: storage/themes/default/partials/main_menu.php:59
        "Customizable & trackable QR codes" => "",
        #: storage/themes/default/partials/main_menu.php:67
        "Convert your social media followers" => "",
        #: storage/themes/default/partials/main_menu.php:97
        #: storage/themes/default/partials/topbar_menu.php:42
        "Admin Panel" => "",
        #: storage/themes/default/partials/shortener.php:7
        "Paste a long link" => "",
        #: storage/themes/default/partials/shortener.php:10
        "Paste up to 10 long urls. One URL per line." => "",
        #: storage/themes/default/partials/shortener.php:41
        #: storage/themes/default/user/edit.php:267
        "Redirect" => "",
        #: storage/themes/default/partials/shortener.php:61
        "If you need a custom alias, you can enter it below." => "",
        #: storage/themes/default/partials/shortener.php:72
        "By adding a password, you can restrict the access." => "",
        #: storage/themes/default/partials/shortener.php:83
        #: storage/themes/default/user/edit.php:305
        "Link Expiration" => "",
        #: storage/themes/default/partials/shortener.php:84
        "Set an expiration date to disable the link." => "",
        #: storage/themes/default/partials/shortener.php:87
        #: storage/themes/default/user/edit.php:308
        "MM/DD/YYYY" => "",
        #: storage/themes/default/partials/shortener.php:94
        "This can be used to identify URLs on your account." => "",
        #: storage/themes/default/partials/shortener.php:97
        #: storage/themes/default/user/edit.php:315
        "Type your description here" => "",
        #: storage/themes/default/partials/shortener.php:104
        #: storage/themes/default/partials/shortener.php:121
        #: storage/themes/default/user/edit.php:28
        "Meta Tags" => "",
        #: storage/themes/default/partials/shortener.php:106
        #: storage/themes/default/partials/shortener.php:147
        #: storage/themes/default/user/edit.php:54
        "Geo Targeting" => "",
        #: storage/themes/default/partials/shortener.php:109
        #: storage/themes/default/partials/shortener.php:186
        #: storage/themes/default/pricing/index.php:48
        #: storage/themes/default/user/billing.php:76
        #: storage/themes/default/user/edit.php:124
        "Device Targeting" => "",
        #: storage/themes/default/partials/shortener.php:125
        #: storage/themes/default/user/edit.php:32
        "Custom Banner" => "",
        #: storage/themes/default/partials/shortener.php:126
        #: storage/themes/default/partials/shortener.php:132
        #: storage/themes/default/user/edit.php:33
        #: storage/themes/default/user/edit.php:39
        "Enter your custom meta title" => "",
        #: storage/themes/default/partials/shortener.php:131
        #: storage/themes/default/user/edit.php:38
        "Meta Title" => "",
        #: storage/themes/default/partials/shortener.php:137
        #: storage/themes/default/user/edit.php:44
        "Meta Description" => "",
        #: storage/themes/default/partials/shortener.php:138
        #: storage/themes/default/user/edit.php:45
        "Enter your custom meta description" => "",
        #: storage/themes/default/partials/shortener.php:149
        #: storage/themes/default/partials/shortener.php:188
        #: storage/themes/default/partials/shortener.php:237
        #: storage/themes/default/user/edit.php:56
        #: storage/themes/default/user/edit.php:126
        #: storage/themes/default/user/edit.php:193
        "+ Add" => "",
        #: storage/themes/default/partials/shortener.php:152
        #: storage/themes/default/user/edit.php:59
        "If you have different pages for different countries then it is possible to redirect users to that page using the same URL. Simply choose the country and enter the URL." => "",
        #: storage/themes/default/partials/shortener.php:166
        #: storage/themes/default/user/edit.php:75
        #: storage/themes/default/user/edit.php:104
        "All States" => "",
        #: storage/themes/default/partials/shortener.php:176
        #: storage/themes/default/partials/shortener.php:206
        #: storage/themes/default/user/edit.php:85
        #: storage/themes/default/user/edit.php:114
        #: storage/themes/default/user/edit.php:145
        #: storage/themes/default/user/edit.php:162
        "Type the url to redirect user to." => "",
        #: storage/themes/default/partials/shortener.php:192
        #: storage/themes/default/user/edit.php:130
        "If you have different pages for different devices (such as mobile, tablet etc) then it is possible to redirect users to that page using the same short URL. Simply choose the device and enter the URL." => "",
        #: storage/themes/default/partials/shortener.php:215
        #: storage/themes/default/user/edit.php:171
        "Targeting Pixels" => "",
        #: storage/themes/default/partials/shortener.php:216
        #: storage/themes/default/user/edit.php:172
        "Add your targeting pixels below from the list. Please make sure to enable them in the pixels settings." => "",
        #: storage/themes/default/partials/shortener.php:235
        #: storage/themes/default/user/edit.php:191
        "Parameter Builder" => "",
        #: storage/themes/default/partials/shortener.php:241
        #: storage/themes/default/user/edit.php:197
        "You can add custom parameters like UTM to the link above using this tool. Choose the parameter name and then assign a value. These will be added during redirection." => "",
        #: storage/themes/default/partials/shortener.php:247
        #: storage/themes/default/user/edit.php:204
        #: storage/themes/default/user/edit.php:219
        "Parameter name" => "",
        #: storage/themes/default/partials/shortener.php:253
        #: storage/themes/default/user/edit.php:210
        #: storage/themes/default/user/edit.php:225
        "Parameter value" => "",
        #: storage/themes/default/partials/shortener.php:262
        "Single" => "",
        #: storage/themes/default/partials/shortener.php:263
        "Multiple" => "",
        #: storage/themes/default/partials/sidebar_menu.php:80
        "Teams" => "",
        #: storage/themes/default/partials/sidebar_menu.php:90
        "All Tools" => "",
        #: storage/themes/default/partials/stats_nav.php:3
        #: storage/themes/default/pricing/checkout.php:73
        "Summary" => "",
        #: storage/themes/default/partials/stats_nav.php:6
        "Countries" => "",
        #: storage/themes/default/partials/stats_nav.php:9
        #: storage/themes/default/stats/platforms.php:16
        #: storage/themes/default/user/campaignstats.php:85
        "Platforms" => "",
        #: storage/themes/default/partials/stats_nav.php:12
        #: storage/themes/default/stats/browsers.php:16
        "Browsers" => "",
        #: storage/themes/default/partials/stats_nav.php:15
        #: storage/themes/default/stats/languages.php:16
        "Languages" => "",
        #: storage/themes/default/partials/stats_nav.php:18
        "Referrers" => "",
        #: storage/themes/default/partials/topbar_menu.php:14
        "Dark Mode" => "",
        #: storage/themes/default/partials/topbar_menu.php:17
        "Light Mode" => "",
        #: storage/themes/default/partials/topbar_menu.php:31
        "{t} Notifications" => "",
        #: storage/themes/default/partials/topbar_menu.php:41
        "Admin" => "",
        #: storage/themes/default/partials/topbar_menu.php:56
        #: storage/themes/default/user/settings.php:99
        "Public Profile" => "",
        #: storage/themes/default/partials/topbar_menu.php:60
        #: storage/themes/default/user/affiliate.php:1
        "Affiliate" => "",
        #: storage/themes/default/partials/topbar_menu.php:66
        "Log out" => "",
        #: storage/themes/default/pixels/edit.php:6
        "View Links" => "",
        #: storage/themes/default/pixels/edit.php:18
        #: storage/themes/default/pixels/new.php:27
        "Pixel Name" => "",
        #: storage/themes/default/pixels/edit.php:19
        #: storage/themes/default/pixels/new.php:28
        "Shopify Campaign" => "",
        #: storage/themes/default/pixels/edit.php:24
        #: storage/themes/default/pixels/new.php:33
        "Pixel Tag" => "",
        #: storage/themes/default/pixels/edit.php:25
        #: storage/themes/default/pixels/new.php:34
        "Numerical or alphanumerical values only" => "",
        #: storage/themes/default/pixels/edit.php:29
        "Update Pixel" => "",
        #: storage/themes/default/pixels/index.php:6
        #: storage/themes/default/pixels/index.php:44
        #: storage/themes/default/pixels/new.php:1
        #: storage/themes/default/pixels/new.php:39
        "Add Pixel" => "",
        #: storage/themes/default/pixels/index.php:61
        #: storage/themes/default/pixels/new.php:56
        "What are tracking pixels?" => "",
        #: storage/themes/default/pixels/index.php:65
        #: storage/themes/default/pixels/new.php:60
        "Ad platforms such as Facebook and Adwords provide a conversion tracking tool to allow you to gather data on your customers and how they behave on your website. By adding your pixel ID from either of the platforms, you will be able to optimize marketing simply by using short URLs." => "",
        #: storage/themes/default/pixels/index.php:66
        #: storage/themes/default/pixels/new.php:61
        "More info" => "",
        #: storage/themes/default/pixels/new.php:11
        "Pixel Provider" => "",
        #: storage/themes/default/pricing/checkout.php:13
        "Payment Method" => "",
        #: storage/themes/default/pricing/checkout.php:28
        "Billing Address" => "",
        #: storage/themes/default/pricing/checkout.php:30
        "Full Name" => "",
        #: storage/themes/default/pricing/checkout.php:34
        #: storage/themes/default/qr/edit.php:122
        #: storage/themes/default/qr/new.php:134
        "Address" => "",
        #: storage/themes/default/pricing/checkout.php:40
        #: storage/themes/default/qr/edit.php:132
        #: storage/themes/default/qr/new.php:144
        "City" => "",
        #: storage/themes/default/pricing/checkout.php:46
        "State/Province" => "",
        #: storage/themes/default/pricing/checkout.php:54
        #: storage/themes/default/qr/edit.php:144
        #: storage/themes/default/qr/new.php:156
        "Country" => "",
        #: storage/themes/default/pricing/checkout.php:62
        "Zip/Postal code" => "",
        #: storage/themes/default/pricing/checkout.php:87
        "Subtotal" => "",
        #: storage/themes/default/pricing/checkout.php:94
        "Promo Code" => "",
        #: storage/themes/default/pricing/checkout.php:100
        "Apply" => "",
        #: storage/themes/default/pricing/checkout.php:104
        "Apply promo code" => "",
        #: storage/themes/default/pricing/checkout.php:108
        "Discount" => "",
        #: storage/themes/default/pricing/checkout.php:120
        "One-time payment" => "",
        #: storage/themes/default/pricing/checkout.php:120
        "Billed" => "",
        #: storage/themes/default/pricing/checkout.php:125
        "Checkout" => "",
        #: storage/themes/default/pricing/checkout.php:131
        "By subscribing to this plan, you agree to our Terms & Conditions. Subscription is charged in {c}. If you have any questions, please contact us." => "",
        #: storage/themes/default/pricing/index.php:6
        "Simple Pricing" => "",
        #: storage/themes/default/pricing/index.php:8
        "Transparent pricing for everyone. Always know what you will pay." => "",
        #: storage/themes/default/pricing/index.php:21
        "Monthly" => "",
        #: storage/themes/default/pricing/index.php:25
        "Yearly" => "",
        #: storage/themes/default/pricing/index.php:39
        "Free" => "",
        #: storage/themes/default/pricing/index.php:44
        #: storage/themes/default/user/billing.php:73
        "URLs allowed" => "",
        #: storage/themes/default/pricing/index.php:45
        #: storage/themes/default/user/billing.php:74
        "Clicks per month" => "",
        #: storage/themes/default/pricing/index.php:46
        #: storage/themes/default/user/billing.php:72
        "Custom Aliases" => "",
        #: storage/themes/default/pricing/index.php:47
        #: storage/themes/default/user/billing.php:75
        "Geotargeting" => "",
        #: storage/themes/default/pricing/index.php:54
        #: storage/themes/default/teams/index.php:60
        #: storage/themes/default/user/billing.php:82
        "Team Members" => "",
        #: storage/themes/default/pricing/index.php:56
        #: storage/themes/default/user/billing.php:84
        "Campaigns & Link Rotator" => "",
        #: storage/themes/default/pricing/index.php:57
        "Multiple Domains" => "",
        #: storage/themes/default/pricing/index.php:58
        "Custom Parameters" => "",
        #: storage/themes/default/pricing/index.php:59
        #: storage/themes/default/teams/edit.php:70
        #: storage/themes/default/teams/index.php:172
        #: storage/themes/default/user/billing.php:85
        #: storage/themes/default/user/campaignstats.php:102
        #: storage/themes/default/user/stats.php:61
        "Export Data" => "",
        #: storage/themes/default/pricing/index.php:61
        #: storage/themes/default/user/billing.php:87
        "URL Customization" => "",
        #: storage/themes/default/pricing/index.php:62
        #: storage/themes/default/user/billing.php:88
        "Advertisement-Free" => "",
        #: storage/themes/default/private.php:5
        "Hello" => "",
        #: storage/themes/default/private.php:7
        "Thanks for you interest but this website is currently used privately." => "",
        #: storage/themes/default/qr/edit.php:9 storage/themes/default/qr/new.php:32
        "QR Code Name" => "",
        #: storage/themes/default/qr/edit.php:21 storage/themes/default/qr/edit.php:22
        #: storage/themes/default/qr/new.php:43 storage/themes/default/qr/new.php:44
        "Your Text" => "",
        #: storage/themes/default/qr/edit.php:34 storage/themes/default/qr/new.php:54
        "Your Link" => "",
        #: storage/themes/default/qr/edit.php:51 storage/themes/default/qr/new.php:69
        "Subject" => "",
        #: storage/themes/default/qr/edit.php:52 storage/themes/default/qr/new.php:70
        "Job Application" => "",
        #: storage/themes/default/qr/edit.php:56 storage/themes/default/qr/new.php:74
        "Your message here to be sent as email" => "",
        #: storage/themes/default/qr/edit.php:64
        #: storage/themes/default/qr/edit.php:110 storage/themes/default/qr/new.php:23
        #: storage/themes/default/qr/new.php:80 storage/themes/default/qr/new.php:122
        "Phone" => "",
        #: storage/themes/default/qr/edit.php:77 storage/themes/default/qr/new.php:24
        #: storage/themes/default/qr/new.php:91
        "SMS" => "",
        #: storage/themes/default/qr/edit.php:94 storage/themes/default/qr/new.php:13
        #: storage/themes/default/qr/new.php:106
        "vCard" => "",
        #: storage/themes/default/qr/edit.php:98 storage/themes/default/qr/new.php:110
        "First Name" => "",
        #: storage/themes/default/qr/edit.php:102
        #: storage/themes/default/qr/new.php:114
        "Last Name" => "",
        #: storage/themes/default/qr/edit.php:106
        #: storage/themes/default/qr/new.php:118
        "Organization" => "",
        #: storage/themes/default/qr/edit.php:118
        #: storage/themes/default/qr/new.php:130
        "Website" => "",
        #: storage/themes/default/qr/edit.php:123
        #: storage/themes/default/qr/new.php:135
        "Social" => "",
        #: storage/themes/default/qr/edit.php:128
        #: storage/themes/default/qr/new.php:140
        "Street" => "",
        #: storage/themes/default/qr/edit.php:136
        #: storage/themes/default/qr/new.php:148
        "State" => "",
        #: storage/themes/default/qr/edit.php:140
        #: storage/themes/default/qr/new.php:152
        "Zipcode" => "",
        #: storage/themes/default/qr/edit.php:163
        #: storage/themes/default/qr/new.php:175
        "Linekdin" => "",
        #: storage/themes/default/qr/edit.php:173 storage/themes/default/qr/new.php:25
        #: storage/themes/default/qr/new.php:183
        "WiFi" => "",
        #: storage/themes/default/qr/edit.php:177
        #: storage/themes/default/qr/new.php:187
        "Network SSID" => "",
        #: storage/themes/default/qr/edit.php:185
        #: storage/themes/default/qr/new.php:195
        "Encryption" => "",
        #: storage/themes/default/qr/edit.php:197
        #: storage/themes/default/qr/new.php:211
        "Colors" => "",
        #: storage/themes/default/qr/edit.php:218
        #: storage/themes/default/qr/new.php:232
        "Foreground" => "",
        #: storage/themes/default/qr/edit.php:246
        #: storage/themes/default/qr/new.php:260
        "Gradient Direction" => "",
        #: storage/themes/default/qr/edit.php:248
        #: storage/themes/default/qr/new.php:262
        "Vertical" => "",
        #: storage/themes/default/qr/edit.php:249
        #: storage/themes/default/qr/new.php:263
        "Horizontal" => "",
        #: storage/themes/default/qr/edit.php:250
        #: storage/themes/default/qr/new.php:264
        "Radial" => "",
        #: storage/themes/default/qr/edit.php:251
        #: storage/themes/default/qr/new.php:265
        "Diagonal" => "",
        #: storage/themes/default/qr/edit.php:262
        #: storage/themes/default/qr/new.php:280
        "Design" => "",
        #: storage/themes/default/qr/edit.php:313
        #: storage/themes/default/qr/new.php:331
        "Matrix Style" => "",
        #: storage/themes/default/qr/edit.php:317
        #: storage/themes/default/qr/edit.php:334
        #: storage/themes/default/qr/new.php:335 storage/themes/default/qr/new.php:352
        "Square" => "",
        #: storage/themes/default/qr/edit.php:321
        #: storage/themes/default/qr/new.php:339
        "Rounded" => "",
        #: storage/themes/default/qr/edit.php:325
        #: storage/themes/default/qr/new.php:343
        "Dots" => "",
        #: storage/themes/default/qr/edit.php:330
        #: storage/themes/default/qr/new.php:348
        "Eye Style" => "",
        #: storage/themes/default/qr/edit.php:338
        #: storage/themes/default/qr/new.php:356
        "Circle" => "",
        #: storage/themes/default/qr/edit.php:349
        #: storage/themes/default/qr/new.php:367
        #: storage/themes/default/stats/partial.php:8
        #: storage/themes/default/user/index.php:128
        "QR Code" => "",
        #: storage/themes/default/qr/edit.php:360
        #: storage/themes/default/qr/new.php:378
        "You will be able to download the QR code in PDF or SVG after it has been generated." => "",
        #: storage/themes/default/qr/index.php:25
        "Download as PNG" => "",
        #: storage/themes/default/qr/index.php:26
        "Download as SVG" => "",
        #: storage/themes/default/qr/index.php:27
        "Download as PDF" => "",
        #: storage/themes/default/qr/index.php:34
        #: storage/themes/default/stats/partial.php:32
        "Scans" => "",
        #: storage/themes/default/qr/index.php:63
        "What are QR Codes?" => "",
        #: storage/themes/default/qr/index.php:67
        "A QR code is a machine-readable code consisting of an array of black and white squares, typically used for storing URLs or other information for reading by the camera on a smartphone." => "",
        #: storage/themes/default/qr/new.php:9
        "Static QR" => "",
        #: storage/themes/default/qr/new.php:9
        "Non-Trackable" => "",
        #: storage/themes/default/qr/new.php:18
        "Dynamic QR" => "",
        #: storage/themes/default/qr/new.php:18
        "Trackable" => "",
        #: storage/themes/default/qr/new.php:205
        "Preview" => "",
        #: storage/themes/default/qr/new.php:272
        "Eye Color" => "",
        #: storage/themes/default/qr/new.php:324
        "Custom Logo" => "",
        #: storage/themes/default/qr/new.php:373
        "Generate QR" => "",
        #: storage/themes/default/splash/create.php:2
        #: storage/themes/default/splash/edit.php:2
        "A custom splash page is a transitional page where you can customize it however you want." => "",
        #: storage/themes/default/splash/create.php:18
        #: storage/themes/default/splash/edit.php:18
        "Counter" => "",
        #: storage/themes/default/splash/create.php:26
        #: storage/themes/default/splash/edit.php:26
        "Link to Product" => "",
        #: storage/themes/default/splash/create.php:32
        #: storage/themes/default/splash/edit.php:32
        "Custom Title" => "",
        #: storage/themes/default/splash/create.php:33
        #: storage/themes/default/splash/edit.php:33
        "Get a $10 discount" => "",
        #: storage/themes/default/splash/create.php:38
        #: storage/themes/default/splash/edit.php:38
        "Upload Banner" => "",
        #: storage/themes/default/splash/create.php:40
        #: storage/themes/default/splash/edit.php:40
        "The minimum width must be 980px and the height must be between 250 and 500. The format must be a PNG or a JPG. Maximum size is 500KB" => "",
        #: storage/themes/default/splash/create.php:45
        #: storage/themes/default/splash/edit.php:45
        "Upload Avatar" => "",
        #: storage/themes/default/splash/index.php:64
        "What is a custom splash page?" => "",
        #: storage/themes/default/splash/index.php:68
        "A custom splash page is a transitional page where you can add a banner and a logo along with a message to represent your brand or company. When creating a short link, you will be able to assign the page to your short url. Users who visit your url will briefly see the page before being redirected to their destination." => "",
        #: storage/themes/default/stats/browsers.php:19
        #: storage/themes/default/stats/countries.php:19
        #: storage/themes/default/stats/index.php:21
        #: storage/themes/default/stats/languages.php:19
        #: storage/themes/default/stats/platforms.php:19
        "Choose a date range to update stats" => "",
        #: storage/themes/default/stats/browsers.php:30
        "Top Browsers" => "",
        #: storage/themes/default/stats/countries.php:16
        #: storage/themes/default/user/campaignstats.php:51
        #: storage/themes/default/user/stats.php:36
        "Visitor Map" => "",
        #: storage/themes/default/stats/countries.php:30
        #: storage/themes/default/user/campaignstats.php:61
        #: storage/themes/default/user/stats.php:46
        "Top Countries" => "",
        #: storage/themes/default/stats/countries.php:42
        "Cities" => "",
        #: storage/themes/default/stats/countries.php:43
        "Select a region in the map above to display city data." => "",
        #: storage/themes/default/stats/index.php:36
        #: storage/themes/default/user/index.php:117
        "Recent Activity" => "",
        #: storage/themes/default/stats/index.php:59
        #: storage/themes/default/user/index.php:155
        "Direct, email or others" => "",
        #: storage/themes/default/stats/languages.php:30
        "Top Languages" => "",
        #: storage/themes/default/stats/partial.php:13
        "Bio Link" => "",
        #: storage/themes/default/stats/partial.php:40
        "Unique Scans" => "",
        #: storage/themes/default/stats/partial.php:48
        "Top Country" => "",
        #: storage/themes/default/stats/partial.php:56
        "Top Referrer" => "",
        #: storage/themes/default/stats/platforms.php:30
        "Top Platforms" => "",
        #: storage/themes/default/stats/referrers.php:16
        "Top Referrers" => "",
        #: storage/themes/default/stats/referrers.php:22
        "Direct, email and others" => "",
        #: storage/themes/default/stats/referrers.php:31
        "Social Media" => "",
        #: storage/themes/default/teams/edit.php:1
        "Edit Member" => "",
        #: storage/themes/default/teams/edit.php:11
        #: storage/themes/default/teams/edit.php:12
        #: storage/themes/default/teams/index.php:113
        #: storage/themes/default/teams/index.php:114
        "Permissions" => "",
        #: storage/themes/default/teams/edit.php:14
        #: storage/themes/default/teams/index.php:116
        "Create Links" => "",
        #: storage/themes/default/teams/edit.php:15
        #: storage/themes/default/teams/index.php:117
        "Edit Links" => "",
        #: storage/themes/default/teams/edit.php:16
        #: storage/themes/default/teams/index.php:118
        "Delete Links" => "",
        #: storage/themes/default/teams/edit.php:22
        #: storage/themes/default/teams/index.php:124
        "Delete QR" => "",
        #: storage/themes/default/teams/edit.php:29
        #: storage/themes/default/teams/index.php:131
        "Delete Bio" => "",
        #: storage/themes/default/teams/edit.php:34
        #: storage/themes/default/teams/index.php:136
        "Create Splash" => "",
        #: storage/themes/default/teams/edit.php:35
        #: storage/themes/default/teams/index.php:137
        "Edit Splash" => "",
        #: storage/themes/default/teams/edit.php:36
        #: storage/themes/default/teams/index.php:138
        "Delete Splash" => "",
        #: storage/themes/default/teams/edit.php:41
        #: storage/themes/default/teams/index.php:143
        "Create Overlay" => "",
        #: storage/themes/default/teams/edit.php:42
        #: storage/themes/default/teams/index.php:144
        "Edit Overlay" => "",
        #: storage/themes/default/teams/edit.php:43
        #: storage/themes/default/teams/index.php:145
        "Delete Overlay" => "",
        #: storage/themes/default/teams/edit.php:48
        #: storage/themes/default/teams/index.php:150
        "Create Pixels" => "",
        #: storage/themes/default/teams/edit.php:49
        #: storage/themes/default/teams/index.php:151
        "Edit Pixels" => "",
        #: storage/themes/default/teams/edit.php:50
        #: storage/themes/default/teams/index.php:152
        "Delete Pixels" => "",
        #: storage/themes/default/teams/edit.php:55
        "Add Branded Domain" => "",
        #: storage/themes/default/teams/edit.php:56
        "Delete Branded Domain" => "",
        #: storage/themes/default/teams/edit.php:61
        #: storage/themes/default/teams/index.php:163
        "Create Campaigns" => "",
        #: storage/themes/default/teams/edit.php:62
        #: storage/themes/default/teams/index.php:164
        "Edit Campaigns" => "",
        #: storage/themes/default/teams/edit.php:63
        #: storage/themes/default/teams/index.php:165
        "Delete Campaigns" => "",
        #: storage/themes/default/teams/index.php:7
        #: storage/themes/default/teams/index.php:52
        #: storage/themes/default/teams/index.php:103
        "Add Member" => "",
        #: storage/themes/default/teams/index.php:32
        #: storage/themes/default/user/campaigns.php:30
        "Inactive" => "",
        #: storage/themes/default/teams/index.php:51
        "No members found. You can invite one." => "",
        #: storage/themes/default/teams/index.php:69
        "Permission" => "",
        #: storage/themes/default/teams/index.php:73
        "Create: A create event will allow your team member to shorten links, create splash pages & overlay and campaigns." => "",
        #: storage/themes/default/teams/index.php:74
        "Edit: An edit event will allow your team member to edit links, splash pages & overlay and campaigns." => "",
        #: storage/themes/default/teams/index.php:75
        "Delete: A delete event will allow your team member to delete links, splash pages & overlay and campaigns." => "",
        #: storage/themes/default/teams/index.php:156
        "Branded Domain" => "",
        #: storage/themes/default/teams/index.php:157
        "Add Custom Domain" => "",
        #: storage/themes/default/teams/index.php:158
        "Delete Custom Domain" => "",
        #: storage/themes/default/teams/index.php:179
        "Invite" => "",
        #: storage/themes/default/user/affiliate.php:6
        "Affiliate Link" => "",
        #: storage/themes/default/user/affiliate.php:19
        "Referral History" => "",
        #: storage/themes/default/user/affiliate.php:26
        "Commission" => "",
        #: storage/themes/default/user/affiliate.php:27
        "Referred On" => "",
        #: storage/themes/default/user/affiliate.php:28
        "Paid On" => "",
        #: storage/themes/default/user/affiliate.php:37
        "Approved" => "",
        #: storage/themes/default/user/affiliate.php:39
        "Paid" => "",
        #: storage/themes/default/user/affiliate.php:41
        "Rejected" => "",
        #: storage/themes/default/user/affiliate.php:43
        #: storage/themes/default/user/affiliate.php:47
        "Pending" => "",
        #: storage/themes/default/user/affiliate.php:59
        "Affiliate Rate" => "",
        #: storage/themes/default/user/affiliate.php:62
        "per qualifying sales" => "",
        #: storage/themes/default/user/affiliate.php:63
        "Minimum earning of {amount} is required for payment." => "",
        #: storage/themes/default/user/affiliate.php:66
        "Terms" => "",
        #: storage/themes/default/user/billing.php:7
        "Subscription History" => "",
        #: storage/themes/default/user/billing.php:13
        #: storage/themes/default/user/billing.php:43
        "Transaction ID" => "",
        #: storage/themes/default/user/billing.php:15
        "Since" => "",
        #: storage/themes/default/user/billing.php:16
        "Next Payment" => "",
        #: storage/themes/default/user/billing.php:17
        "Status" => "",
        #: storage/themes/default/user/billing.php:37
        "Payment History" => "",
        #: storage/themes/default/user/billing.php:45
        "Date" => "",
        #: storage/themes/default/user/billing.php:53
        "Refunded" => "",
        #: storage/themes/default/user/billing.php:54
        "Free Trial" => "",
        #: storage/themes/default/user/billing.php:70
        "Current Plan" => "",
        #: storage/themes/default/user/billing.php:97
        #: storage/themes/default/user/billing.php:114
        "Cancel Membership" => "",
        #: storage/themes/default/user/billing.php:100
        "You can cancel your membership whenever your want. Upon request, your membership will be canceled right before your next payment period. This means you can still enjoy premium features until the end of your membership." => "",
        #: storage/themes/default/user/billing.php:101
        #: storage/themes/default/user/billing.php:130
        "Cancel membership" => "",
        #: storage/themes/default/user/billing.php:118
        "We respect your decision and we are sorry to see you go. If you want to share anything with us, please use the box below and we will do our best to improve our service." => "",
        #: storage/themes/default/user/billing.php:125
        "Reason for cancellation" => "",
        #: storage/themes/default/user/campaigns.php:6
        #: storage/themes/default/user/campaigns.php:59
        #: storage/themes/default/user/campaigns.php:83
        "Create a Campaign" => "",
        #: storage/themes/default/user/campaigns.php:41
        "Rotator" => "",
        #: storage/themes/default/user/campaigns.php:46
        "views" => "",
        #: storage/themes/default/user/campaigns.php:47
        "links" => "",
        #: storage/themes/default/user/campaigns.php:69
        "What is a campaign?" => "",
        #: storage/themes/default/user/campaigns.php:73
        "A campaign can be used to group links together for various purpose. You can use the dedicated rotator link where a random link will be chosen and redirected to among the group. You will also be able to view aggregated statistics for a campaign." => "",
        #: storage/themes/default/user/campaigns.php:89
        #: storage/themes/default/user/campaigns.php:126
        "Campaign Name" => "",
        #: storage/themes/default/user/campaigns.php:89
        #: storage/themes/default/user/campaigns.php:126
        "required" => "",
        #: storage/themes/default/user/campaigns.php:93
        #: storage/themes/default/user/campaigns.php:130
        "Rotator Slug" => "",
        #: storage/themes/default/user/campaigns.php:93
        #: storage/themes/default/user/campaigns.php:130
        "optional" => "",
        #: storage/themes/default/user/campaigns.php:95
        #: storage/themes/default/user/campaigns.php:132
        "If you want to set a custom alias for the rotator link, you can fill this field." => "",
        #: storage/themes/default/user/campaigns.php:99
        #: storage/themes/default/user/campaigns.php:136
        "Access" => "",
        #: storage/themes/default/user/campaigns.php:100
        #: storage/themes/default/user/campaigns.php:137
        "Disabling this option will deactivate the rotator link." => "",
        #: storage/themes/default/user/campaigns.php:109
        "Create Campaign" => "",
        #: storage/themes/default/user/campaigns.php:120
        #: storage/themes/default/user/campaigns.php:146
        "Update Campaign" => "",
        #: storage/themes/default/user/campaignstats.php:7
        #: storage/themes/default/user/stats.php:7
        "Export Stats" => "",
        #: storage/themes/default/user/campaignstats.php:16
        "Traffic Distribution" => "",
        #: storage/themes/default/user/campaignstats.php:73
        "Browser" => "",
        #: storage/themes/default/user/campaignstats.php:107
        #: storage/themes/default/user/stats.php:66
        "Choose a range to export data as CSV. Exported data will including information like date, city and country, os, browser, referer and language." => "",
        #: storage/themes/default/user/campaignstats.php:112
        #: storage/themes/default/user/links.php:69
        #: storage/themes/default/user/stats.php:71
        "Export" => "",
        #: storage/themes/default/user/edit.php:20
        "URL" => "",
        #: storage/themes/default/user/edit.php:281
        "Alias" => "",
        #: storage/themes/default/user/index.php:12
        #: storage/themes/default/user/index.php:22
        "Today" => "",
        #: storage/themes/default/user/index.php:34
        "Recent Clicks" => "",
        #: storage/themes/default/user/index.php:48
        "We are currently manually approving links. As soon as the link is approved, you will be able to start using it." => "",
        #: storage/themes/default/user/index.php:58
        "Recent Links" => "",
        #: storage/themes/default/user/index.php:62
        #: storage/themes/default/user/links.php:9
        "Search for links" => "",
        #: storage/themes/default/user/index.php:78
        #: storage/themes/default/user/links.php:32
        "Select All" => "",
        #: storage/themes/default/user/index.php:81
        #: storage/themes/default/user/links.php:35
        "Unarchive Selected" => "",
        #: storage/themes/default/user/index.php:83
        #: storage/themes/default/user/links.php:37
        "Archive Selected" => "",
        #: storage/themes/default/user/index.php:87
        #: storage/themes/default/user/index.php:236
        #: storage/themes/default/user/links.php:41
        #: storage/themes/default/user/links.php:142
        "Add to Campaign" => "",
        #: storage/themes/default/user/index.php:90
        #: storage/themes/default/user/links.php:44
        "Delete Selected" => "",
        #: storage/themes/default/user/index.php:101
        "No links found. You can create some." => "",
        #: storage/themes/default/user/index.php:131
        "Bio Page" => "",
        #: storage/themes/default/user/index.php:190
        #: storage/themes/default/user/links.php:96
        "Short Link Info" => "",
        #: storage/themes/default/user/index.php:198
        #: storage/themes/default/user/links.php:104
        "Download" => "",
        #: storage/themes/default/user/index.php:225
        #: storage/themes/default/user/links.php:131
        "Done" => "",
        #: storage/themes/default/user/index.php:253
        #: storage/themes/default/user/links.php:159
        "Add" => "",
        #: storage/themes/default/user/links.php:16
        "Sort Results" => "",
        #: storage/themes/default/user/links.php:18
        "Latest" => "",
        #: storage/themes/default/user/links.php:19
        "Oldest" => "",
        #: storage/themes/default/user/links.php:20
        "Most Popular" => "",
        #: storage/themes/default/user/links.php:21
        "Less Popular" => "",
        #: storage/themes/default/user/links.php:67
        "Export Links" => "",
        #: storage/themes/default/user/links.php:68
        "This tool allows you to generate a list of urls in CSV format. Some basic data such clicks will be included as well." => "",
        #: storage/themes/default/user/settings.php:5
        "You have used a social network to login. Please note that in this case you don't have a password set." => "",
        #: storage/themes/default/user/settings.php:9
        "You have used a social network to login. You will need to choose a username." => "",
        #: storage/themes/default/user/settings.php:20
        "Avatar" => "",
        #: storage/themes/default/user/settings.php:22
        "By default, we will use the Gravatar associated to your email. Uploaded avatars must be square with the width ranging from 200-500px with a maximum size of 500kb." => "",
        #: storage/themes/default/user/settings.php:37
        "Please note that if you change your email, you will need to activate your account again." => "",
        #: storage/themes/default/user/settings.php:45
        "A username is required for your public profile to be visible." => "",
        #: storage/themes/default/user/settings.php:54
        #: storage/themes/default/user/settings.php:61
        "Leave blank to keep current one." => "",
        #: storage/themes/default/user/settings.php:68
        "Default Domain" => "",
        #: storage/themes/default/user/settings.php:81
        "Default Redirection" => "",
        #: storage/themes/default/user/settings.php:100
        "Public profile will be activated only when this option is public." => "",
        #: storage/themes/default/user/settings.php:112
        "Media Gateway" => "",
        #: storage/themes/default/user/settings.php:113
        "If enabled, special pages will be automatically created for your media URLs (e.g. youtube, vimeo, dailymotion...)." => "",
        #: storage/themes/default/user/settings.php:126
        "If enabled, you will receive occasional newsletters from us." => "",
        #: storage/themes/default/user/settings.php:135
        "Save Settings" => "",
        #: storage/themes/default/user/settings.php:144
        "Two-Factor Authentication (2FA)" => "",
        #: storage/themes/default/user/settings.php:146
        "2FA is an enhanced level security for your account. Each time you login, an extra step where you will need to enter a unique code will be required to gain access to your account. To enable 2FA, please click the button below and download the <strong>Google Authenticator</strong> app from Apple Store or Play Store." => "",
        #: storage/themes/default/user/settings.php:149
        "View QR" => "",
        #: storage/themes/default/user/settings.php:152
        "Secret Key" => "",
        #: storage/themes/default/user/settings.php:155
        "Important" => "",
        #: storage/themes/default/user/settings.php:157
        "You need to scan the code above with the app. You need to backup the QR code by saving it and save the key somewhere safe in case you lose your phone. You will not be able to login if you can't provide the code, in that case you will need to contact us. If you disable 2FA and re-enable it, you will need to scan a new code." => "",
        #: storage/themes/default/user/settings.php:158
        "Disable 2FA" => "",
        #: storage/themes/default/user/settings.php:160
        "Activate 2FA" => "",
        #: storage/themes/default/user/settings.php:166
        #: storage/themes/default/user/settings.php:210
        "Developer API Key" => "",
        #: storage/themes/default/user/settings.php:173
        #: storage/themes/default/user/settings.php:185
        "Delete your account" => "",
        #: storage/themes/default/user/settings.php:174
        #: storage/themes/default/user/settings.php:190
        "We respect your privacy and as such you can delete your account permanently and remove all your data from our server. Please note that this action is permanent and cannot be reversed." => "",
        #: storage/themes/default/user/settings.php:175
        "Delete Permanently" => "",
        #: storage/themes/default/user/settings.php:215
        "If you regenerate your key, the current key will be revoked and your applications might stop working until you update the api key with the new one." => "",
        #: storage/themes/default/user/tools.php:7
        #: storage/themes/default/user/tools.php:22
        "Quick Shortener" => "",
        #: storage/themes/default/user/tools.php:8
        #: storage/themes/default/user/tools.php:42
        "Bookmarklet" => "",
        #: storage/themes/default/user/tools.php:9
        #: storage/themes/default/user/tools.php:61
        "Full-Page Script" => "",
        #: storage/themes/default/user/tools.php:10
        #: storage/themes/default/user/tools.php:90
        "Zapier Integration" => "",
        #: storage/themes/default/user/tools.php:12
        #: storage/themes/default/user/tools.php:131
        "Slack Integration" => "",
        #: storage/themes/default/user/tools.php:24
        "This tool allows you to quickly shorten any URL in any page without using any fancy method. This is perhaps the quickest and the easiest method available for you to shorten URLs across all platforms. This method will generate a unique short URL for you that you will be able to access anytime from your dashboard." => "",
        #: storage/themes/default/user/tools.php:26
        "Use your quick URL below to shorten any URL by adding the URL after /q/?u=. <strong>For security reasons, you need to be logged in and using the remember me feature.</strong> Check out the examples below to understand how to use this method." => "",
        #: storage/themes/default/user/tools.php:29
        "Examples" => "",
        #: storage/themes/default/user/tools.php:32
        #: storage/themes/default/user/tools.php:51
        "Notes" => "",
        #: storage/themes/default/user/tools.php:34
        "Please note that this method does not return anything. It simply redirects the user to the redirection page. However if you need the actual short URL, you can always get it from your dashboard." => "",
        #: storage/themes/default/user/tools.php:44
        "You can use our bookmarklet tool to instantaneously shorten any site you are currently viewing and if you are logged in on our site, it will be automatically saved to your account for future access. Simply drag the following link to your bookmarks bar or copy the link and manually add it to your favorites." => "",
        #: storage/themes/default/user/tools.php:46
        "Drag me to your Bookmark Bar" => "",
        #: storage/themes/default/user/tools.php:46
        "Shorten URL" => "",
        #: storage/themes/default/user/tools.php:48
        "If you can't drag the link above, use your browser's bookmark editor to create a new bookmark and add the URL below as the link." => "",
        #: storage/themes/default/user/tools.php:53
        "Please note that for secured sites that use SSL, the widget will not pop up due to security issues. In that case, the user will be redirected our site where you will be able to view your short URL." => "",
        #: storage/themes/default/user/tools.php:63
        "This script allows you to shorten all (or select) URLs on your website very easily. All you need to do is to copy and paste the code below at the end of your page. You can customize the selector as you wish to target URLs in a specific selector. Note you can just  copy the code below because everything is already for you." => "",
        #: storage/themes/default/user/tools.php:67
        "Choosing custom select" => "",
        #: storage/themes/default/user/tools.php:68
        "By default, this script shortens all URLs in a page. If you want to target specific URLs then you can add a selector parameter. You can see an example below where the script will only shorten URLs having a class named mylink or all direct link in the .content container or all links in the .comments container" => "",
        #: storage/themes/default/user/tools.php:72
        "Excluding domain names" => "",
        #: storage/themes/default/user/tools.php:73
        "You can exclude domain names if you wish. You can add an exclude parameter to exclude domain names. The example below shortens all URLs but excludes URLs from google.com or gempixel.com" => "",
        #: storage/themes/default/user/tools.php:77
        "Restricting domain names" => "",
        #: storage/themes/default/user/tools.php:78
        "You can restrict domain names by adding an include parameter to restrict domain names. The example below shortens all URLs within the include domain name." => "",
        #: storage/themes/default/user/tools.php:98
        "You can use Zapier to automate campaigns. By adding the URL to the zapier webhook, we will send you important information to that webhook so you can use them." => "",
        #: storage/themes/default/user/tools.php:101
        #: storage/themes/default/user/tools.php:115
        "URL Zapier Notification" => "",
        #: storage/themes/default/user/tools.php:103
        "We will send a notification to this URL when you create a short URL." => "",
        #: storage/themes/default/user/tools.php:106
        #: storage/themes/default/user/tools.php:119
        "Views Zapier Notification" => "",
        #: storage/themes/default/user/tools.php:108
        "We will send a notification to this URL when someone clicks your URL." => "",
        #: storage/themes/default/user/tools.php:114
        "Sample Response" => "",
        #: storage/themes/default/user/tools.php:135
        "Connected" => "",
        #: storage/themes/default/user/tools.php:139
        "You can integrate this app with your slack account and shorten directly from the slack interface using the command line below. This slack integration will save all of your links in your account in case you need to access them later. Please see below how to use the command." => "",
        #: storage/themes/default/user/tools.php:141
        "Slack Command" => "",
        #: storage/themes/default/user/tools.php:144
        "Example" => "",
        #: storage/themes/default/user/tools.php:147
        "Example with custom name" => "",
        #: storage/themes/default/user/tools.php:148
        "To send a custom alias, use the following paramter (ABCDXYZ). This will tell the script to choose shorten the link with the custom alias ABCDXYZ." => "",
        #: storage/themes/default/user/tools.php:154
        "The slack command will return you the short link if everything goes well. In case there is an error, it will return you the original link. If you use the custom parameter and the alias is already taken, the script will automatically increment the alias by 1 - this means if you choose 'google' and 'google' is not available, the script will use google-1" => "",
    ]
];