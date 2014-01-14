activate-grid
=============

A Joomla! plugin that utilises jquery masonry to create a responsive grid layout for articles and selected social media

<h1>ActivateGrid Component</h1>
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
<img src="images/grid-helper-1.png" alt="Helper-1" width="631" height="147" />
<p>The image above  summarizes the process of how the <strong>ActivateGrid</strong> works.  The extension needs the provider's api key for proper  connection and to import your feed items.</p>
<p>Below, you will  find instructions on how to request api keys for: Facebook, Twitter,  Instagram and Storify.</p>
<p>&nbsp;</p>
<h4>2.2.1 Services</h4>
<p>The supported  services are:</p>
<ol>
	<li>
		<p><strong>Facebook</strong> (user timeline and pages) </p>
	</li>
	<li>
		<p><strong>Twitter</strong> </p>
	</li>
	<li>
		<p><strong>Instagram</strong> </p>
	</li>
	<li>
		<p><strong>Storify</strong> </p>
	</li>
</ol>
<p>The services  that will be added in the future include:</p>
<ol>
	<li>
		<p>Google+ </p>
	</li>
	<li>
		<p>YouTube </p>
	</li>
	<li>
		<p>LinkedIn </p>
	</li>
	<li>
		<p>Pinterest </p>
	</li>
	<li>Flickr</li>
</ol>
<p>If you decide to  use one of the currently available social networks for the component,  you need to <strong>request</strong> the relative <strong>API Key</strong> for the provider (Facebook, Twitter, etc), then go to: <strong>Components</strong> -&gt; <strong>Activate Grid</strong> -&gt; <strong>Setup</strong> -&gt; <em>Tab to the provider you want to  use</em>.</p>
<p>Before you  continue with the component set up you will need to generate API keys  for each of the social networks you want to include within your grid.  The method is slightly different for each social network and the  processes for each are listed below.</p>
<p>&nbsp;</p>
<h3>Generate and set API keys</h3>
<h4>Facebook</h4>
<ol>
	<li>
		<p>Go to <span lang="zxx" xml:lang="zxx"><U><a href="https://developers.facebook.com/">developers.facebook.com</a></U></span>,  	login or sign up. </p>
	</li>
	<li>
		<p>Click on  	&quot;<strong>Apps</strong>&quot;  	in the top menu. </p>
	</li>
	<li>
		<p>Click  	&quot;<strong>+Create app</strong>&quot;,  	insert &quot;<em>ActivateGrid</em>&quot;  	as <strong>name</strong> and press <strong>Continue</strong> </p>
	</li>
	<li>
		<p>Go in  to App  	Settings and <strong>disable</strong> the &quot;<strong>Sandbox mode,</strong>&quot;  	then <strong>save</strong>. </p>
	</li>
	<li>
		<p>At the top of  	the page you will find your <strong>App  	ID </strong>and <strong>App  	Secret</strong>.  These need to be  	copied and pasted into the appropriate fields.</p>
	</li>
	<li>
		<p>Open your  	Joomla! Administrator panel, login and open the component options:</p>
	</li>
</ol>
<p><br />
</p>
<p> (Administrator  panel &gt; Components &gt; Activategrid &gt; Setup)<br />
</p>
<ol start="7">
	<li>
		<p>Choose the  	Facebook tab, <strong>paste</strong> the App ID and App Secret and then <strong>Save</strong>. </p>
	</li>
	<li>
		<p>Now press  	&quot;<strong>Generate your Access  	Token</strong>&quot;. </p>
	</li>
	<li>
		<p>It should  	display,  &quot;URL Generating...DONE!&quot; if yes, press  	&quot;<strong>Authorize the Facebook  	App&quot;. If not </strong>an error will  	explain the problem, resolve it and repeat the Access Token  	Generation process. </p>
	</li>
	<li>
		<p>Login in to  	Facebook and confirm. </p>
	</li>
	<li>
		<p>You are now  	ready to <strong>import</strong> your <strong>Facebook timeline</strong>.  	If you want to import a stream from a <strong>Facebook  	Page</strong>, then follow the next  	step. </p>
	</li>
	<li>
		<p>To import  	the posts from a <strong>Facebook Page</strong> instead of from a <strong>user's  	timeline</strong>, go to the <strong>ActivateGrid's</strong> settings, then Facebook tab, and insert the <strong>Page  	name</strong>, then <strong>Save</strong>. </p>
	</li>
</ol>
<h4>Twitter</h4>
<ol>
	<li>
		<p>Go to <span lang="zxx" xml:lang="zxx"><U><a href="https://dev.twitter.com/">dev.twitter.com</a></U></span>,  	login or sign up. </p>
	</li>
	<li>
		<p>Click &quot;<strong>My  	applications</strong>&quot; You will see  	this as you hover over your avatar at the top-right of the page. </p>
	</li>
	<li>
		<p>Click &quot;<strong>Create  	a new application</strong>&quot;. </p>
	</li>
	<li>
		<p>Insert the  	following data: </p>
		<ul>
			<li>
				<p><strong>Name</strong>: <strong>ActivateGrid </strong> </p>
			</li>
			<li>
				<p><strong>Description</strong>:  		&quot;Twitter app for the Joomla! component ActivateGrid&quot; </p>
			</li>
			<li>
				<p><strong>Website</strong>:  		Your Joomla! site URL. </p>
			</li>
			<li>
				<p><strong>Callback  		URL</strong> - leave empty </p>
			</li>
			<li>
				<p>Agree Terms  		and Conditions and complete and type in the <strong>captcha</strong> security code. </p>
			</li>
		</ul>
	</li>
	<li>
		<p>Click  	&quot;<strong>Generate my access token</strong>&quot;  	at the bottom of the page. </p>
	</li>
	<li>
		<p>Copy and  	paste the following to the ActivateGrid settings &gt; <strong>Twitter</strong>: </p>
		<ul>
			<li>
				<p><strong>Consumer  		key </strong> </p>
			</li>
			<li>
				<p><strong>Consumer  		secret </strong> </p>
			</li>
			<li>
				<p><strong>Access  		token </strong> </p>
			</li>
			<li>
				<p><strong>Access  		token secret </strong> </p>
			</li>
		</ul>
	</li>
	<li>
		<p><strong>Insert</strong> the <strong>username</strong> from which you want to import the tweets and <strong>Save</strong> </p>
	</li>
	<li>
		<p>You are now  	ready to import your Twitter activities to your Joomla! website. </p>
	</li>
</ol>
<h4>&nbsp;</h4>
<h4>Instagram </h4>
<h4>Go to <span lang="zxx" xml:lang="zxx"><U><a href="http://instagram.com/developer/">instagram.com/developer</a></U></span>,  login or sign up. </h4>
<ol>
	<li>
		<p>Click <strong>Manage  	Clients</strong> then <strong>Register  	a New Client</strong> </p>
	</li>
	<li>
		<p>Insert the  	following data: </p>
		<ul>
			<li>
				<p><strong>Name</strong>:  		ActivateGrid </p>
			</li>
			<li>
				<p><strong>Description</strong>:  		&quot;Instagram app for the Joomla! component ActivateGrid&quot; </p>
			</li>
			<li>
				<p><strong>Website</strong>:  		Your Joomla! site URL. </p>
			</li>
			<li>
				<p><strong>OAuth  		redirect_uri</strong>: http://<strong>{YOUR  		DOMAIN HERE}</strong>/administrator/index.php?option=com_activategrid </p>
			</li>
		</ul>
	</li>
	<li>
		<p>Copy and  	paste the following codes in the ActivateGrid settings &gt; <strong>Instagram</strong>: </p>
		<ul>
			<li>
				<p><strong>Client ID </strong> </p>
			</li>
			<li>
				<p><strong>Client  		secret </strong> </p>
			</li>
			<li>
				<p><strong>Redirect  		URI </strong> </p>
			</li>
		</ul>
	</li>
	<li>
		<p>Once you have  	pasted the information above, press <strong>Save</strong>. </p>
	</li>
	<li>
		<p>Now, press  	&quot;<strong>Generate your Access  	Token</strong>&quot;. This process will  	auto-fill the Access token and the username, you do not need to  	insert them. </p>
	</li>
	<li>
		<p>You should  	read &quot;URL Generating...DONE!&quot; if yes press &quot;<strong>Authorize  	the Instagram App&quot;. If not </strong>an  	error will explain the problem, solve it and repeat the process. </p>
	</li>
	<li>
		<p>You are now  	ready to <strong>import</strong> your <strong>Instagram photos </strong>in  	Joomla!</p>
	</li>
</ol>
<h4>&nbsp;</h4>
<h4>Storify </h4>
<ol>
	<li>
		<p>Go to <span lang="zxx" xml:lang="zxx"><U><a href="http://dev.storify.com/request">dev.storify.com</a></U></span> </p>
	</li>
	<li>
		<p>Complete the  	required information on the form and press &quot;<strong>Request  	API key</strong>&quot;, you will then  	receive an email with your personal <strong>Storify  	API key</strong>. </p>
	</li>
	<li>
		<p><strong>Attention</strong> - In order to setup properly the extension, following the <span lang="zxx" xml:lang="zxx"><U><a href="#auth">Storify  	instructions</a></U></span> your  	Storify username and password are requested to proceed. </p>
	</li>
	<li>
		<p>In the  	ActivateGrid settings &gt; <strong>Storify</strong> insert your Storify username and password, then <strong>Save  	*</strong>. </p>
	</li>
	<li>
		<p>Now, press  	&quot;<strong>Generate your Access  	Token</strong>&quot;. This process will  	auto-fill the Access Token and the Storify Website URL, you do not  	need to insert them. </p>
	</li>
	<li>
		<p>You are now  	ready to <strong>import</strong> your <strong>Storify stories </strong>into  	Joomla!</p>
	</li>
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
<p>&nbsp;</p>
<h2>3. Front end configuration</h2>
<h3>3.1 How to show the grid</h3>
<p>If you want a  grid that <strong>fills </strong>the <strong>page</strong> (or most  of the display area), you have to create a <strong>menu item </strong>and  connect it to the <strong>component</strong>. This process is  necessary because the <strong>extension</strong> is a Joomla!  component. Each component needs to be &quot;connected&quot; to a menu  item in order for it to work. </p>
<p>Besides,  creating a new menu item means creating a new page and that in turn  requires a new URL.</p>
<p>Please, follow  the following instructions on how to create a <strong>Full Page Grid  View</strong>:</p>
<ol>
	<li>
		<p>Create a menu  	item </p>
		<ul>
			<li>
				<p><strong>Menus</strong> -&gt; <em>Main Menu (or any)</em>-&gt; <strong>New</strong> </p>
			</li>
			<li>
				<p>Name the  		page </p>
			</li>
			<li>
				<p>Press the  		blue button<strong> Menu Item Type</strong> -&gt; <strong>Select</strong> and choose <strong>Activate Grid</strong> -&gt; <strong>Responsive Grid View</strong> </p>
			</li>
		</ul>
	</li>
	<li>
		<p>Choose your  	settings </p>
		<ul>
			<li>
				<p>Select the  		tab &quot;<strong>Activate Grid  		options</strong>&quot; to customize the  		page. </p>
			</li>
			<li>
				<p>Here you can  		select which feeds to include in this grid instance. Choose the  		categories you want, (Facebook, Instagram, your own categories,  		etc.) to show in the page using the field &quot;<strong>Select  		source categories</strong>&quot;.  		Remember that you can also display standard Joomla! articles in the  		grid, just select the categories that you want to show. The feed  		items are imported in Joomla! as articles so they are organized in  		categories as well. These categories are created automatically. </p>
			</li>
			<li>
				<p>If you want  		to change the grid's element size, set &quot;<strong>Grid  		item width</strong>&quot; and &quot;<strong>Grid  		item height</strong>&quot;. </p>
			</li>
			<li>
				<p>Select the  		order in which to display your elements (by date, alphabetically,  		random) </p>
			</li>
			<li>
				<p>Select the  		animation effect you wish to apply to the elements </p>
			</li>
			<li>
				<p>If you want  		to show a title or introductory text above the grid, use the Yes/No  		switches to choose what to display. Select a category in &quot;<strong>Select  		category intro&quot;</strong> and then  		put your text in <strong>Content</strong> -&gt; <strong>Category Manager</strong> -&gt; [Click the category you chose] -&gt; [Write the text in the  		description field]. </p>
			</li>
			<li>
				<p><strong>Save</strong> </p>
			</li>
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
	<li>
		<p><strong>Go  	into Extensions</strong> -&gt; <strong>Module  	Manager</strong> -&gt; <strong>New</strong> -&gt; <strong>ActivateGrid</strong> </p>
	</li>
	<li>
		<p>Set a <strong>name</strong> and a <strong>position</strong> (search in your template guide if you do not know the positions). </p>
	</li>
	<li>
		<p>Select the  	menu item that you just created (in <strong>3.1  	How to show the grid</strong>, above).  	The menu item represents an instance of the Activate Grid component. </p>
	</li>
	<li>
		<p>Choose the <strong>Menu Assignment</strong>. </p>
	</li>
	<li>
		<p><strong>Enable</strong> the module and Save. </p>
	</li>
</ol>
<p>The module is  now visible in the pages and position that you chose.</p>
<p>&nbsp;&nbsp;</p>
<p><strong>3.2.2 Grid  inside an article</strong></p>
<p>To display the <strong>grid within an article</strong>, you need to:</p>
<ol>
	<li>
		<p>Create an  	instance of the core (follow <strong>3.1 How to show the grid</strong>).</p>
	</li>
	<li>
		<p>Create the  	module, following<strong> 3.2.1 Grid in a module position</strong>.</p>
	</li>
	<li>
		<p>Create an  	article and use the Joomla! feature &quot;<strong>loadposition</strong>&quot;  	or &quot;<strong>loadmodule</strong>&quot;.  	Activate Grid supports both these features. For example, if you put  	the Grid module into a <strong>custom  	position</strong> named  	&quot;<em>grid_module_position&quot;</em>,  	you can put &quot;{loadposition grid_module_position} in the  	article's code. This trick will load the grid inside the article.  	You can also use loadmodule, using the name of the created module,  	in the same way of before. </p>
	</li>
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
<h3>4.5 Manage grid elements content</h3>
<p>You can choose  to enable or disable some of content inside a grid element. In <strong>Components</strong> -&gt; <strong>Activate Grid</strong> -&gt; <strong>Setup</strong> in each <strong>social network</strong>'s tab  you can for example remove the social network's icon, or display the  tweet date etc. </p>
<h3>4.6 Extras</h3>
<p><strong>Name of the  category in the grid's element</strong></p>
<p>If you are  interested in displaying the social network’s name in the box, or  in the scenario you are using your own articles' categories, you can  display the category name in the box, by going to  the menu item  settings, in the tab &quot;<strong>Activate Grid options</strong>&quot;  and enabling &quot;<strong>Display category name&quot;</strong>. </p>
<p><strong>Category  description</strong></p>
<p>You can also put  HTML content on the top of the grid, using &quot;<strong>Display  category intro</strong>&quot; and selecting &quot;<strong>Source  category intro&quot;</strong>.</p>
