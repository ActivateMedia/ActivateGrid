activate-grid
=============

A Joomla! extension that utilises jquery masonry to create a responsive grid layout for articles and selected social media

<h1>ActivateGrid - Joomla! Component</h1>
<h2>Guide</h2>
<h2>Table of contents</h2>
<ul>
	<li>
		<strong>1. What is the ActivateGrid</strong>
	</li>
	<li>
		<strong>2. Back end configuration</strong>
		<ul>
			<li>
				2.1 Installation
			</li>
			<li>
			2.2 Setup
				<ul>
					<li>2.2.1 Services
						<ul>
							<li>Add a new service (Facebook, Twitter, etc.)</li>
							<li>Generate and set API keys</li>
						</ul>
					</li>
					<li>Style
						<ul>
							<li>Custom CSS interface</li>
						</ul>
					</li>
				</ul>
			</li>
			<li>2.3 Import the feed items manually</li>
			<li>2.4 Import the feed items automatically</li>
		</ul>
	</li>
	<li><strong>3. Front end configuration</strong>
		<ul>
			<li>3.1 How to show the grid</li>
			<li>3.2 Examples
				<ul>
					<li>3.2.1 Grid in a module position</li>
					<li>3.2.2 Grid inside an article</li>
					<li>3.2.3 Display Joomla! articles in the grid</li>
				</ul>
			</li>
		</ul>
	</li>
	<li>
		<strong>4. Tips &amp; Tricks</strong>
		<ul>
			<li>4.1 Customize the grid elements</li>
			<li>4.2 Disable services temporarily</li>
			<li>4.3 Review imported feed items before publish</li>
			<li>4.4 Disable animations</li>
			<li>4.5 Manage grid elements content</li>
			<li>4.6 Extras</li>
		</ul>
	</li>
	<li><strong>5. Ready to use!</strong></li>
</ul>
<p>&nbsp;</p>
<h2><strong>1. What is the ActivateGrid  Joomla! component?</strong></h2>
<p>The ActivateGrid  component allows you to collect the posts from your <strong>Facebook</strong>, <strong>Instagram</strong>, <strong>Twitter</strong> or <strong>Storify</strong> accounts and display them in an animated and dynamic <strong>grid</strong>.  It also allows you to integrate your Joomla! articles into the grid  using the title and image of each article.</p>
<p>Thanks to the <strong>responsive </strong><strong>design</strong><strong> </strong>the grid can be used on all desktop and mobile devices.</p>
<p>&nbsp;</p>
<h2>2. Back end configuration</h2>
<h3>2.1 Installation</h3>
<p><strong>Download</strong> and install the package from your Joomla! Administrator panel.</p>
<p>The installation  process does not require any action from the user. <br />
	In the package  &quot;<strong>pkg_activategrid.zip</strong>&quot; you will find:</p>
<ul>
	<li>
		<p>com_activategrid  	- The core of the component </p>
	</li>
	<li>
		<p>com_activategrid_pi  	- This component creates a way to call the core using a cron job  	(you can uninstall it if you import the feed items manually - <strong>Components</strong> -&gt; <strong>Activate Grid</strong> -&gt; <strong>Import feed items</strong>) </p>
	</li>
	<li>
		<p>mod_activategrid  	- This module allows you to position the grid in a specific module  	position of your Joomla! site. </p>
	</li>
</ul>
<p>&nbsp;</p>
<h3>2.2 Setup<br />
</h3>
<img src="http://activatemedia.co.uk/img/grid-helper-1.png" alt="Helper-1" width="631" height="147" />
<p>The image above  summarizes the process of how the <strong>ActivateGrid</strong> works.  The extension needs the provider's api key for proper  connection and to import your feed items.</p>
<p>Below, you will  find instructions on how to request api keys for: Facebook, Twitter,  Instagram and Storify.</p>
<p>&nbsp;</p>
<h4>2.2.1 Services</h4>
<p>The supported  services are:</p>
<ol>
	<li>		<strong>Facebook</strong> (user timeline and pages) </li>
	<li>		<strong>Twitter</strong> </li>
	<li>		<strong>Instagram</strong> </li>
	<li>		<strong>Storify</strong> </li>
</ol>
<p>The services  that will be added in the future include:</p>
<ol>
	<li>		Google+ </li>
	<li>		YouTube </li>
	<li>		LinkedIn </li>
	<li>		Pinterest </li>
	<li>Flickr</li>
</ol>
<p>If you decide to  use one of the currently available social networks for the component,  you need to <strong>request</strong> the relative <strong>API Key</strong> for the provider (Facebook, Twitter, etc), then go to: <strong>Components</strong> -&gt; <strong>Activate Grid</strong> -&gt; <strong>Setup</strong> -&gt; <em>Tab to the provider you want to  use</em>.</p>
<p>Before you  continue with the component set up you will need to generate API keys  for each of the social networks you want to include within your grid.  The method is slightly different for each social network and the  processes for each are listed below.</p>
<p>&nbsp;</p>
<h3>Generate and set API keys</h3>
<h4>Facebook</h4>
<ol>
	<li>		Go to <span lang="zxx" xml:lang="zxx"><U><a href="https://developers.facebook.com/">developers.facebook.com</a></U></span>,  	login or sign up. </li>
	<li>		Click on  	&quot;<strong>Apps</strong>&quot;  	in the top menu. </li>
	<li>		Click  	&quot;<strong>+Create app</strong>&quot;,  	insert &quot;<em>ActivateGrid</em>&quot;  	as <strong>name</strong> and press <strong>Continue</strong> </li>
	<li>		Go in  to App  	Settings and <strong>disable</strong> the &quot;<strong>Sandbox mode,</strong>&quot;  	then <strong>save</strong>. </li>
	<li>		At the top of  	the page you will find your <strong>App  	ID </strong>and <strong>App  	Secret</strong>.  These need to be  	copied and pasted into the appropriate fields.</li>
	<li>		Open your  	Joomla! Administrator panel, login and open the component options:</li>
</ol>
<br />
(Administrator  panel &gt; Components &gt; Activategrid &gt; Setup)<br />
<ol start="7">
	<li>
		Choose the  	Facebook tab, <strong>paste</strong> the App ID and App Secret and then <strong>Save</strong>. </li>
	<li>
		Now press  	&quot;<strong>Generate your Access  	Token</strong>&quot;. </li>
	<li>
		It should  	display,  &quot;URL Generating...DONE!&quot; if yes, press  	&quot;<strong>Authorize the Facebook  	App&quot;. If not </strong>an error will  	explain the problem, resolve it and repeat the Access Token  	Generation process. </li>
	<li>
		Login in to  	Facebook and confirm. </li>
	<li>
		You are now  	ready to <strong>import</strong> your <strong>Facebook timeline</strong>.  	If you want to import a stream from a <strong>Facebook  	Page</strong>, then follow the next  	step. </li>
	<li>
		To import  	the posts from a <strong>Facebook Page</strong> instead of from a <strong>user's  	timeline</strong>, go to the <strong>ActivateGrid's</strong> settings, then Facebook tab, and insert the <strong>Page  	name</strong>, then <strong>Save</strong>. </li>
</ol>
<h4>Twitter</h4>
<ol>
	<li>		Go to <span lang="zxx" xml:lang="zxx"><U><a href="https://dev.twitter.com/">dev.twitter.com</a></U></span>,  	login or sign up. </li>
	<li>		Click &quot;<strong>My  	applications</strong>&quot; You will see  	this as you hover over your avatar at the top-right of the page. </li>
	<li>		Click &quot;<strong>Create  	a new application</strong>&quot;. </li>
	<li>
		Insert the  	following data: <ul>
			<li>				<strong>Name</strong>: <strong>ActivateGrid </strong> </li>
			<li>				<strong>Description</strong>:  		&quot;Twitter app for the Joomla! component ActivateGrid&quot; </li>
			<li>				<strong>Website</strong>:  		Your Joomla! site URL. </li>
			<li>				<strong>Callback  		URL</strong> - leave empty </li>
			<li>				Agree Terms  		and Conditions and complete and type in the <strong>captcha</strong> security code. </li>
		</ul>
	</li>
	<li>		Click  	&quot;<strong>Generate my access token</strong>&quot;  	at the bottom of the page. </li>
	<li>		Copy and  	paste the following to the ActivateGrid settings &gt; <strong>Twitter</strong>: <ul>
			<li>				<strong>Consumer  		key </strong> </li>
			<li>				<strong>Consumer  		secret </strong> </li>
			<li>				<strong>Access  		token </strong> </li>
			<li>				<strong>Access  		token secret </strong> </li>
		</ul>
	</li>
	<li>		<strong>Insert</strong> the <strong>username</strong> from which you want to import the tweets and <strong>Save</strong> </li>
	<li>		You are now  	ready to import your Twitter activities to your Joomla! website. </li>
</ol>
<h4>&nbsp;</h4>
<h4>Instagram </h4>
<h4>Go to <span lang="zxx" xml:lang="zxx"><U><a href="http://instagram.com/developer/">instagram.com/developer</a></U></span>,  login or sign up. </h4>
<ol>
	<li>		Click <strong>Manage  	Clients</strong> then <strong>Register  	a New Client</strong> </li>
	<li>
		Insert the  	following data: <ul>
			<li>				<strong>Name</strong>:  		ActivateGrid </li>
			<li>				<strong>Description</strong>:  		&quot;Instagram app for the Joomla! component ActivateGrid&quot; </li>
			<li>				<strong>Website</strong>:  		Your Joomla! site URL. </li>
			<li>				<strong>OAuth  		redirect_uri</strong>: http://<strong>{YOUR  		DOMAIN HERE}</strong>/administrator/index.php?option=com_activategrid </li>
		</ul>
	</li>
	<li>		Copy and  	paste the following codes in the ActivateGrid settings &gt; <strong>Instagram</strong>: <ul>
			<li>				<strong>Client ID </strong> </li>
			<li>				<strong>Client  		secret </strong> </li>
			<li>				<strong>Redirect  		URI </strong> </li>
		</ul>
	</li>
	<li>		Once you have  	pasted the information above, press <strong>Save</strong>. </li>
	<li>		Now, press  	&quot;<strong>Generate your Access  	Token</strong>&quot;. This process will  	auto-fill the Access token and the username, you do not need to  	insert them. </li>
	<li>		You should  	read &quot;URL Generating...DONE!&quot; if yes press &quot;<strong>Authorize  	the Instagram App&quot;. If not </strong>an  	error will explain the problem, solve it and repeat the process. </li>
	<li>		You are now  	ready to <strong>import</strong> your <strong>Instagram photos </strong>in  	Joomla!</li>
</ol>
<h4>&nbsp;</h4>
<h4>Storify </h4>
<ol>
	<li>		Go to <span lang="zxx" xml:lang="zxx"><U><a href="http://dev.storify.com/request">dev.storify.com</a></U></span> </li>
	<li>		Complete the  	required information on the form and press &quot;<strong>Request  	API key</strong>&quot;, you will then  	receive an email with your personal <strong>Storify  	API key</strong>. </li>
	<li>		<strong>Attention</strong> - In order to setup properly the extension, following the <span lang="zxx" xml:lang="zxx"><U><a href="#auth">Storify  	instructions</a></U></span> your  	Storify username and password are requested to proceed. </li>
	<li>		In the  	ActivateGrid settings &gt; <strong>Storify</strong> insert your Storify username and password, then <strong>Save  	*</strong>. </li>
	<li>		Now, press  	&quot;<strong>Generate your Access  	Token</strong>&quot;. This process will  	auto-fill the Access Token and the Storify Website URL, you do not  	need to insert them. </li>
	<li>		You are now  	ready to <strong>import</strong> your <strong>Storify stories </strong>into  	Joomla!</li>
</ol>
<p><strong>* Your  Storify account details will be removed from your Joomla! Database  once you generate your access token, pressing the green button.</strong></p>
<p><br />
		<br />
</p>
<h3>2.3 Importing the feed items manually</h3>
<p>When you have  finished adding the social network feeds to the components settings,  you are able to import the content of the feeds from the social  networks.</p>
<p>If you want to  import the social network feeds manually go to <strong>Components</strong> -&gt; <strong>Activate Grid</strong>, then click the green button  &quot;<strong>Import feed items</strong><strong>&quot;</strong> you will then  see how many feed elements have been imported from each social  network feed.</p>
<h3>&nbsp;</h3>
<h3>2.4 Importing the feed items automatically</h3>
<p>Importing the  social network feeds automatically is probably the optimum way to  utilise the system in most situations. This does require a bit more  time to configure. </p>
<p>Keep in mind  that, like most software, the component does not make decisions. It  will not import items from a feed unless instructed to do so.  There  are two ways to automate the process.</p>
<p>Option 1: Create a <strong>cron job</strong> on your web server (<strong>scheduled  task </strong>for Windows Server). </p>
<p>Option 2:  Install the Joomla! <span lang="zxx" xml:lang="zxx"><U><a href="file:///h">JPrc  Cronjobs</a></U></span> extension  to emulate the cron job * </p>
<p>* We strongly  recommend utilizing the <strong>1st </strong>option. We have extensively  tested this extension with great success but as in all software  configurations, we can not guarantee results and, can not be held  responsible for any problems caused by this extension.</p>
<p>The URL to set in to a cron job script has now to being created. If you have installed the ActivateGrid installation package, you probably have ActivateGridPI component too. This component hasn't a back end interface, it will be required in this phase for creating a new hidden menu item. Follow the steps below:</p>
<ol>
	<li>If you already have an hidden menu jump to step 3, if not, create an hidden menu (<strong>Menus</strong> -&gt; <strong>Menu Manager</strong> -&gt; <strong>Add a new menu</strong>).</li>
	<li>Enter <strong>Title</strong> -&gt; &quot;Hidden Menu&quot;, <strong>Menu Type</strong> -&gt; &quot;hidden-menu&quot;, <strong>Save &amp; Close</strong>.</li>
	<li>Go inside your hidden menu  (<strong>Menus</strong> -&gt; <em>Hidden Menu</em> -&gt; <strong>Add a New Menu Item</strong>).</li>
	<li>Enter the <strong>Menu Title</strong> -&gt; &quot;<em><strong>activategrid-import</strong></em>&quot; (You can choose your own)</li>
	<li>Select <strong>Menu Item Type</strong>, choose <strong>ActivateGridPI -&gt; URL for cronjob script</strong>.</li>
	<li><strong>Save &amp; Close</strong></li>
</ol>
<p>A new URL is now available on your website and it's like http://yourdomain.com/<strong>activategrid-import</strong> (Or different if you chose a different <strong>Menu Title</strong> or <strong>Alias</strong> in the step 2). In case of your Joomla! is not configured for using URL rewrite, the new URL it's like: http://yourdomain.com/<strong>index.php?option=com_activategrid_pi&amp;view=public_import&amp;Itemid=<em>MENU_ITEM_ID</em></strong></p>
<p>To complete the  setup for importing automatically the feed items, the last step is create a cron job.</p>
<p>We suggest to follow <a href="http://www.cyberciti.biz/faq/how-do-i-add-jobs-to-cron-under-linux-or-unix-oses/" target="_blank">this tutorial</a> that explains the commands to execute on a linux server or <a href="http://windows.microsoft.com/en-gb/windows/schedule-task#1TC=windows-7" target="_blank">this</a> one for Windows Server</p>
<p>If you can't create a cron job, you can install <a href="http://extensions.joomla.org/extensions/administration/admin-desk/19490" target="_blank">this</a> Joomla! extension that will emulate the cron jobs using http requests generated from the front-end, during the navigation of the website's users.</p>
<h2>3. Front end configuration</h2>
<h3>3.1 How to show the grid</h3>
<p>If you want a  grid that <strong>fills </strong>the <strong>page</strong> (or most  of the display area), you have to create a <strong>menu item </strong>and  connect it to the <strong>component</strong>. This process is  necessary because the <strong>extension</strong> is a Joomla!  component. Each component needs to be &quot;connected&quot; to a menu  item in order for it to work. </p>
<p>Besides,  creating a new menu item means creating a new page and that in turn  requires a new URL.</p>
<p>Please, follow  the following instructions on how to create a <strong>Full Page Grid  View</strong>:</p>
<ol>
	<li>
		Create a menu  	item <ul>
			<li>				<strong>Menus</strong> -&gt; <em>Main Menu (or any)</em>-&gt; <strong>New</strong> </li>
			<li>				Name the  		page </li>
			<li>				Press the  		blue button<strong> Menu Item Type</strong> -&gt; <strong>Select</strong> and choose <strong>Activate Grid</strong> -&gt; <strong>Responsive Grid View</strong> </li>
		</ul>
	</li>
	<li>
		Choose your  	settings <ul>
			<li>				Select the  		tab &quot;<strong>Activate Grid  		options</strong>&quot; to customize the  		page. </li>
			<li>				Here you can  		select which feeds to include in this grid instance. Choose the  		categories you want, (Facebook, Instagram, your own categories,  		etc.) to show in the page using the field &quot;<strong>Select  		source categories</strong>&quot;.  		Remember that you can also display standard Joomla! articles in the  		grid, just select the categories that you want to show. The feed  		items are imported in Joomla! as articles so they are organized in  		categories as well. These categories are created automatically. </li>
			<li>				If you want  		to change the grid's element size, set &quot;<strong>Grid  		item width</strong>&quot; and &quot;<strong>Grid  		item height</strong>&quot;. </li>
			<li>				Select the  		order in which to display your elements (by date, alphabetically,  		random) </li>
			<li>				Select the  		animation effect you wish to apply to the elements </li>
			<li>				If you want  		to show a title or introductory text above the grid, use the Yes/No  		switches to choose what to display. Select a category in &quot;<strong>Select  		category intro&quot;</strong> and then  		put your text in <strong>Content</strong> -&gt; <strong>Category Manager</strong> -&gt; [Click the category you chose] -&gt; [Write the text in the  		description field]. </li>
			<li>				<strong>Save</strong> </li>
		</ul>
	</li>
</ol>
<p>Your page is now  ready!</p>
<p>&nbsp;</p>
<h3>3.2 Usage of the ActivateGrid</h3>
<p><strong>3.2.1 Grid in  a module position</strong></p>
<p>If you want to  display the content of the grid in a small footprint, for example on  the side of a page, or into a<strong> module position </strong>you  will need the <strong>ActivateGrid module.</strong> This Joomla!  module is <strong>included</strong> as part of  the <strong>free downloadable package</strong> and is  automatically installed as part of the component.</p>
<p>You need to know  that this module is just an &quot;adaptor&quot; between concept for  module and component. The core of this extension is represented by  the component, so the first step you have to do is: </p>
<p>Follow the same  instructions of <strong>3.1 How to show the grid</strong>, shown  above. Then, setup an <strong>instance</strong> of the Grid component and link the module to the instance that you  just created.</p>
<p><strong>Once  the menu item</strong> has been created </p>
<ol>
	<li>		<strong>Go  	into Extensions</strong> -&gt; <strong>Module  	Manager</strong> -&gt; <strong>New</strong> -&gt; <strong>ActivateGrid</strong> </li>
	<li>		Set a <strong>name</strong> and a <strong>position</strong> (search in your template guide if you do not know the positions). </li>
	<li>		Select the  	menu item that you just created (in <strong>3.1  	How to show the grid</strong>, above).  	The menu item represents an instance of the Activate Grid component. </li>
	<li>		Choose the <strong>Menu Assignment</strong>. </li>
	<li>		<strong>Enable</strong> the module and Save. </li>
</ol>
<p>The module is  now visible in the pages and position that you chose.</p>
<p>&nbsp;&nbsp;</p>
<p><strong>3.2.2 Grid  inside an article</strong></p>
<p>To display the <strong>grid within an article</strong>, you need to:</p>
<ol>
	<li>		Create an  	instance of the core (follow <strong>3.1 How to show the grid</strong>).</li>
	<li>		Create the  	module, following<strong> 3.2.1 Grid in a module position</strong>.</li>
	<li>		Create an  	article and use the Joomla! feature &quot;<strong>loadposition</strong>&quot;  	or &quot;<strong>loadmodule</strong>&quot;.  	Activate Grid supports both these features. For example, if you put  	the Grid module into a <strong>custom  	position</strong> named  	&quot;<em>grid_module_position&quot;</em>,  	you can put &quot;{loadposition grid_module_position} in the  	article's code. This trick will load the grid inside the article.  	You can also use loadmodule, using the name of the created module,  	in the same way of before. </li>
</ol>
<p>&nbsp;</p>
<p><strong>3.2.3 Display  Joomla! articles in the grid</strong></p>
<p>All the elements  of the grid are standard Joomla! articles. Imported feed items are  converted to an article. This means that you can use the <strong>grid  system </strong>for <strong>showing your own articles</strong>, for  example to create a blog listing view. To use the grid for just your  Joomla! articles you only need to install the component and follow  the setup steps described in <strong>3.1 How to show the grid</strong>.</p>
<p>&nbsp;</p>
<h2>4. Tips &amp; Tricks</h2>
<h3>4.1 How to customise the grid elements</h3>
<p>The grid  elements for social network feed or Joomla! category can be styled  the way you want from an interface within the component. To customise  how the grid elements display go to <strong>Components</strong> -&gt; <strong>Activate Grid</strong>, then &quot;<strong>Advanced  Configuration&quot;</strong>.</p>
<p>To change the  element sizes, go into the menu item and open the &quot;<strong>Activate  Grid options</strong>&quot; tab.</p>
<p>&nbsp;</p>
<h3>4.2 Disable services temporarily</h3>
<p>If you have  setup a social network and you want to disable it temporarily, go  into the component settings (<strong>Components</strong> -&gt; <strong>Activate Grid</strong> -&gt; <strong>Setup</strong>) to the  tab named &quot;<strong>Global Config&quot;</strong> where you can <strong>enable</strong> or <strong>disable</strong> the social  network feeds.</p>
<p>&nbsp;</p>
<h3>4.3 Review imported feed items before  publishing them</h3>
<p>If you prefer to  edit or just check the imported feed elements before the publication,  turn-off &quot;<strong>Auto-Publish Feed items</strong>&quot; in the  component settings (<strong>Components</strong> -&gt; <strong>Activate  Grid</strong> -&gt; <strong>Setup</strong>).</p>
<p>&nbsp;</p>
<h3>4.4 Disable animations</h3>
<p>To <strong>disable  the grid animation,</strong> go into the component settings  (<strong>Components</strong> -&gt; <strong>Activate Grid</strong> -&gt; <strong>Setup</strong>) and turn-off  &quot;<strong>Enable animations</strong><strong>&quot;</strong>.  By disabling this feature your website will run <strong>faster</strong><strong> </strong>and<strong> </strong><strong>more  efficiently.</strong></p>
<h3>&nbsp;</h3>
<h3>4.5 Manage grid elements content</h3>
<p>You can choose  to enable or disable some of content inside a grid element. In <strong>Components</strong> -&gt; <strong>Activate Grid</strong> -&gt; <strong>Setup</strong> in each <strong>social network</strong>'s tab  you can for example remove the social network's icon, or display the  tweet date etc. </p>
<h3>&nbsp;</h3>
<h3>4.6 Extras</h3>
<p><strong>Name of the  category in the grid's element</strong></p>
<p>If you are  interested in displaying the social network’s name in the box, or  in the scenario you are using your own articles' categories, you can  display the category name in the box, by going to  the menu item  settings, in the tab &quot;<strong>Activate Grid options</strong>&quot;  and enabling &quot;<strong>Display category name&quot;</strong>. </p>
<p><strong>Category  description</strong></p>
<p>You can also put  HTML content on the top of the grid, using &quot;<strong>Display  category intro</strong>&quot; and selecting &quot;<strong>Source  category intro&quot;</strong>.</p>
