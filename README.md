activate-grid
=============

A Joomla! plugin that utilises jquery masonry to create a responsive grid layout for articles and selected social media

ActivateGrid Component
Guide
Table of contents
•	1. What is the ActivateGrid 
•	2. Back end configuration 
•	2.1 Installation 
•	2.2 Setup 
•	2.2.1 Services 
•	Add a new service (Facebook, Twitter, etc.) 
•	Generate and set API keys 
•	Style 
•	Custom CSS interface 
•	2.3 Import the feed items manually 
•	2.4 Import the feed items automatically 
•	3. Front end configuration 
•	3.1 How to show the grid 
•	3.2 Examples 
•	3.2.1 Grid in a module position 
•	3.2.2 Grid inside an article 
•	3.2.3 Display Joomla! articles in the grid 
•	4. Tips & Tricks 
•	4.1 Customize the grid elements 
•	4.2 Disable services temporarily 
•	4.3 Review imported feed items before publish 
•	4.4 Disable animations 
•	4.5 Manage grid elements content 
•	4.6 Extras 
•	5. Ready to use! 
 
1. What is the ActivateGrid Joomla! component?
The ActivateGrid component allows you to collect the posts from your Facebook, Instagram, Twitter or Storify accounts and display them in an animated and dynamic grid. It also allows you to integrate your Joomla! articles into the grid using the title and image of each article.
Thanks to the responsive design the grid can be used on all desktop and mobile devices.
 
2. Back end configuration
2.1 Installation
Download and install the package from your Joomla! Administrator panel.
The installation process does not require any action from the user. 
In the package "pkg_activategrid.zip" you will find:
•	com_activategrid - The core of the component 
•	com_activategrid_pi - This component creates a way to call the core using a cron job (you can uninstall it if you import the feed items manually - Components -> Activate Grid -> Import feed items) 
•	mod_activategrid - This module allows you to position the grid in a specific module position of your Joomla! site. 
 
2.2 Setup

The image above summarizes the process of how the ActivateGrid works.  The extension needs the provider's api key for proper connection and to import your feed items.
Below, you will find instructions on how to request api keys for: Facebook, Twitter, Instagram and Storify.
 
2.2.1 Services
The supported services are:
1.	Facebook (user timeline and pages) 
2.	Twitter 
3.	Instagram 
4.	Storify 
The services that will be added in the future include:
1.	Google+ 
2.	YouTube 
3.	LinkedIn 
4.	Pinterest 
If you decide to use one of the currently available social networks for the component, you need to request the relative API Key for the provider (Facebook, Twitter, etc), then go to: Components -> Activate Grid -> Setup -> Tab to the provider you want to use.
Before you continue with the component set up you will need to generate API keys for each of the social networks you want to include within your grid. The method is slightly different for each social network and the processes for each are listed below.
 
Generate and set API keys
Facebook
1.	Go to developers.facebook.com, login or sign up. 
2.	Click on "Apps" in the top menu. 
3.	Click "+Create app", insert "ActivateGrid" as name and press Continue 
4.	Go in  to App Settings and disable the "Sandbox mode," then save. 
5.	At the top of the page you will find your App ID and App Secret.  These need to be copied and pasted into the appropriate fields.
6.	Open your Joomla! Administrator panel, login and open the component options:

 (Administrator panel > Components > Activategrid > Setup) 

7.	Choose the Facebook tab, paste the App ID and App Secret and then Save. 
8.	Now press "Generate your Access Token". 
9.	It should display,  "URL Generating...DONE!" if yes, press "Authorize the Facebook App". If not an error will explain the problem, resolve it and repeat the Access Token Generation process. 
10.	Login in to Facebook and confirm. 
11.	You are now ready to import your Facebook timeline. If you want to import a stream from a Facebook Page, then follow the next step. 
12.	To import the posts from a Facebook Page instead of from a user's timeline, go to the ActivateGrid's settings, then Facebook tab, and insert the Page name, then Save. 
Twitter
1.	Go to dev.twitter.com, login or sign up. 
2.	Click "My applications" You will see this as you hover over your avatar at the top-right of the page. 
3.	Click "Create a new application". 
4.	Insert the following data: 
•	Name: ActivateGrid 
•	Description: "Twitter app for the Joomla! component ActivateGrid" 
•	Website: Your Joomla! site URL. 
•	Callback URL - leave empty 
•	Agree Terms and Conditions and complete and type in the captcha security code. 
5.	Click "Generate my access token" at the bottom of the page. 
6.	Copy and paste the following to the ActivateGrid settings > Twitter: 
•	Consumer key 
•	Consumer secret 
•	Access token 
•	Access token secret 
7.	Insert the username from which you want to import the tweets and Save 
8.	You are now ready to import your Twitter activities to your Joomla! website. 
 
Instagram 
Go to instagram.com/developer, login or sign up. 
1.	Click Manage Clients then Register a New Client 
2.	Insert the following data: 
•	Name: ActivateGrid 
•	Description: "Instagram app for the Joomla! component ActivateGrid" 
•	Website: Your Joomla! site URL. 
•	OAuth redirect_uri: http://{YOUR DOMAIN HERE}/administrator/index.php?option=com_activategrid 
3.	Copy and paste the following codes in the ActivateGrid settings > Instagram: 
•	Client ID 
•	Client secret 
•	Redirect URI 
4.	Once you have pasted the information above, press Save. 
5.	Now, press "Generate your Access Token". This process will auto-fill the Access token and the username, you do not need to insert them. 
6.	You should read "URL Generating...DONE!" if yes press "Authorize the Instagram App". If not an error will explain the problem, solve it and repeat the process. 
7.	You are now ready to import your Instagram photos in Joomla!
 
Storify 
1.	Go to dev.storify.com 
2.	Complete the required information on the form and press "Request API key", you will then receive an email with your personal Storify API key. 
3.	Attention - In order to setup properly the extension, following the Storify instructions your Storify username and password are requested to proceed. 
4.	In the ActivateGrid settings > Storify insert your Storify username and password, then Save *. 
5.	Now, press "Generate your Access Token". This process will auto-fill the Access Token and the Storify Website URL, you do not need to insert them. 
6.	You are now ready to import your Storify stories into Joomla!
* Your Storify account details will be removed from your Joomla! Database once you generate your access token, pressing the green button.

2.3 Importing the feed items manually
When you have finished adding the social network feeds to the components settings, you are able to import the content of the feeds from the social networks.
If you want to import the social network feeds manually go to Components -> Activate Grid, then click the green button "Import feed items"  you will then see how many feed elements have been imported from each social network feed.
 
2.4 Importing the feed items automatically
Importing the social network feeds automatically is probably the optimum way to utilise the system in most situations. This does require a bit more time to configure. 
Keep in mind that, like most software, the component does not make decisions. It will not import items from a feed unless instructed to do so.  There are two ways to automate the process.
Option 1: Create a cron job on your web server (scheduled task for Windows Server). 
Option 2: Install the Joomla! JPrc Cronjobs extension to emulate the cron job * 
* We strongly recommend utilizing the 1st option. We have extensively tested this extension with great success but as in all software configurations, we can not guarantee results and, can not be held responsible for any problems caused by this extension.
 
3. Front end configuration
3.1 How to show the grid
If you want a grid that fills the page (or most of the display area), you have to create a menu item and connect it to the component. This process is necessary because the extension is a Joomla! component. Each component needs to be "connected" to a menu item in order for it to work. 
Besides, creating a new menu item means creating a new page and that in turn requires a new URL.
Please, follow the following instructions on how to create a Full Page Grid View:
1.	Create a menu item 
•	Menus -> Main Menu (or any)-> New 
•	Name the page 
•	Press the blue button Menu Item Type -> Select and choose Activate Grid -> Responsive Grid View 
2.	Choose your settings 
•	Select the tab "Activate Grid options" to customize the page. 
•	Here you can select which feeds to include in this grid instance. Choose the categories you want, (Facebook, Instagram, your own categories, etc.) to show in the page using the field "Select source categories". Remember that you can also display standard Joomla! articles in the grid, just select the categories that you want to show. The feed items are imported in Joomla! as articles so they are organized in categories as well. These categories are created automatically. 
•	If you want to change the grid's element size, set "Grid item width" and "Grid item height". 
•	Select the order in which to display your elements (by date, alphabetically, random) 
•	Select the animation effect you wish to apply to the elements 
•	If you want to show a title or introductory text above the grid, use the Yes/No switches to choose what to display. Select a category in "Select category intro" and then put your text in Content -> Category Manager -> [Click the category you chose] -> [Write the text in the description field]. 
•	Save 
Your page is now ready!
 
3.2 Usage of the ActivateGrid
3.2.1 Grid in a module position
If you want to display the content of the grid in a small footprint, for example on the side of a page, or into a module position you will need the ActivateGrid module. This Joomla! module is included as part of  the free downloadable package and is automatically installed as part of the component.
You need to know that this module is just an "adaptor" between concept for module and component. The core of this extension is represented by the component, so the first step you have to do is: 
Follow the same instructions of 3.1 How to show the grid, shown above. Then, setup an instance of the Grid component and link the module to the instance that you just created.
Once the menu item has been created 
1.	Go into Extensions -> Module Manager -> New -> ActivateGrid 
2.	Set a name and a position (search in your template guide if you do not know the positions). 
3.	Select the menu item that you just created (in 3.1 How to show the grid, above). The menu item represents an instance of the Activate Grid component. 
4.	Choose the Menu Assignment. 
5.	Enable the module and Save. 
The module is now visible in the pages and position that you chose.
  
3.2.2 Grid inside an article
To display the grid within an article, you need to:
1.	Create an instance of the core (follow 3.1 How to show the grid).
2.	Create the module, following 3.2.1 Grid in a module position.
3.	Create an article and use the Joomla! feature "loadposition" or "loadmodule". Activate Grid supports both these features. For example, if you put the Grid module into a custom position named "grid_module_position", you can put "{loadposition grid_module_position} in the article's code. This trick will load the grid inside the article. You can also use loadmodule, using the name of the created module, in the same way of before. 
 
3.2.3 Display Joomla! articles in the grid
All the elements of the grid are standard Joomla! articles. Imported feed items are converted to an article. This means that you can use the grid system for showing your own articles, for example to create a blog listing view. To use the grid for just your Joomla! articles you only need to install the component and follow the setup steps described in 3.1 How to show the grid.
 
4. Tips & Tricks
4.1 How to customise the grid elements
The grid elements for social network feed or Joomla! category can be styled the way you want from an interface within the component. To customise how the grid elements display go to Components -> Activate Grid, then "Advanced Configuration".
To change the element sizes, go into the menu item and open the "Activate Grid options" tab.
 
4.2 Disable services temporarily
If you have setup a social network and you want to disable it temporarily, go into the component settings (Components -> Activate Grid -> Setup) to the tab named "Global Config" where you can enable or disable the social network feeds.
 
4.3 Review imported feed items before publishing them
If you prefer to edit or just check the imported feed elements before the publication, turn-off "Auto-Publish Feed items" in the component settings (Components -> Activate Grid -> Setup).
 
4.4 Disable animations
To disable the grid animation, go into the component settings (Components -> Activate Grid -> Setup) and turn-off  "Enable animations". By disabling this feature your website will run faster and more efficiently.
4.5 Manage grid elements content
You can choose to enable or disable some of content inside a grid element. In Components -> Activate Grid -> Setup in each social network's tab you can for example remove the social network's icon, or display the tweet date etc. 
4.6 Extras
Name of the category in the grid's element
If you are interested in displaying the social network’s name in the box, or in the scenario you are using your own articles' categories, you can display the category name in the box, by going to  the menu item settings, in the tab "Activate Grid options" and enabling "Display category name". 
Category description
You can also put HTML content on the top of the grid, using "Display category intro" and selecting "Source category intro".
