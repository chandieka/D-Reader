<p align="center">
    <img src="./public/Logo.png" alt="Logo" style="width:300px;">
</p>
<p align="center" style="font-size: 20px;">
My abs is twiching so hard right now!
<p align="center" style="font-style: italic;">
- Obama with mustache
</p>
</p>

# **D-Reader**

## **About D-Reader**
<p>
<font size="3">Do you feel that reading doujin online is too mainstream now?</font> 
</p>
<p>
<font size="3">Or do you feel that managing your "pOoOoNs" collections using "window file explorer" are not sufficient?</font>
</p>
<p>
    <font size="10"> SAY NO MORE! D-Reader got your back™ </font>
</p>
<p>
<font size="3">D-Reader objective is to have a fully open-source application for allowing you to read, manage, upload, tag and etc for your collections of manga, doujin, CG-Artist, and other kinds of image base galleries.</font>
</p>
<p>
<font size="3">And (hopefully) it will have all the features you find in sad***da or nh**tai with a modern UI and non-bloated code that 
won't hinder the User Experience while they're doing their "business"</font>
</p>

## **Requirement**
- `PHP` 8.x version or higher
- `PHP` rar extension
- `PHP` zip extension
- `PHP` Imagick extension (>=6.5.7) or GD Library (>=2.0)
- Webserver that able to execute PHP scripts
- Potato computer

## **Code Scafolding**
    
Execute the cmd below on the project root directory for code scaffolding
    
    $ composer install
    $ npm install && npm run dev
    $ php artisan storage:link
    $ php artisan migrate:fresh
    $ php artisan db:seed

## **Development Server**
To run a local dev server, execute the cmd below on the project root directory

    php artisan serve

## **Queue & jobs**
Because this project is a cpu intensive apps there are task that will be run outside of Request life-cycle.
Execute the cmd bellow 3 times in different window or run the "run-jobs" scripts located in the root directory

    php artisan queue:work database

## **Installations**

## **TODO:** 
- Docker Compose
- Apache & Nginx config

## **Licenses**

This application is under [**GNU GPL ver. 3**](./LICENSE) license
