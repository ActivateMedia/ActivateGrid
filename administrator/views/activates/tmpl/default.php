    <div class="row-fluid">        
        <div class="span12">
            <div class="row-fluid">
                <div class="span8">
                    <div class="row-fluid">
                        <div class="span6">
                            <a href="?option=com_config&amp;view=component&amp;component=com_activategrid">
                                <button type="button" class="btn btn-large btn-block btn-info"><?=@JText::_(COM_ACTIVATEGRID_CONFIGURATION);?></button>
                            </a>                    
                        </div>
                        <div class="span6">
                            <a href="index.php?option=com_activategrid&view=feeds">
                                <button type="button" class="btn btn-large btn-block btn-success"><?=@JText::_(COM_ACTIVATEGRID_GET_FEEDS);?></button>
                            </a>
                        </div>
                    </div>

                    <div class="row-fluid spacer">                        
                           <div class="span12"></div>                        
                    </div>

                    <div class="row-fluid">
                        <div class="span6">
                            <a href="index.php?option=com_activategrid&view=advancedsettings">
                                <button type="button" class="btn btn-large btn-block"><?=@JText::_(COM_ACTIVATEGRID_ADVANCED_CONFIGURATION);?></button>
                            </a>                    
                        </div>
                        
                        <div class="span6">
                            <a href="http://activatemedia.co.uk/contact.html" target="_blank">
                                <button type="button" class="btn btn-large btn-block btn-danger"><?=@JText::_(COM_ACTIVATEGRID_CONTACT_US);?></button>
                            </a>                    
                        </div>
                    </div>
                    
                    <div class="row-fluid spacer">                        
                           <div class="span12"></div>                        
                    </div>
                                        
                    <legend><?=@JText::_(COM_ACTIVATEGRID_CREDITS);?></legend>                    

                    <legend><?=@JText::_(COM_ACTIVATEGRID_CREDITS_ABOUT);?></legend>
                    <h4><?=@JText::_(COM_ACTIVATEGRID_CREDITS_NAME_LBL);?></h4>
                    <p><?=@JText::_(COM_ACTIVATEGRID_CREDITS_NAME);?></p>

                    <h4><?=@JText::_(COM_ACTIVATEGRID_LOCATION_LBL);?></h4>
                    <p><?=@JText::_(COM_ACTIVATEGRID_LOCATION);?></p>

                    <h4><?=@JText::_(COM_ACTIVATEGRID_TELEPHONE_LBL);?></h4>
                    <p><?=@JText::_(COM_ACTIVATEGRID_TELEPHONE);?></p>

                    <h4><?=@JText::_(COM_ACTIVATEGRID_WEBSITE_LBL);?></h4>
                    <p><?=@JText::_(COM_ACTIVATEGRID_WEBSITE);?></p>

                    <h4><?=@JText::_(COM_ACTIVATEGRID_EMAIL_LBL);?></h4>
                    <p><?=@JText::_(COM_ACTIVATEGRID_EMAIL);?></p>                                                
                </div>
                <div class="span4">
                    <fieldset class="form-horizontal">
                        <img src="<?=JURI::root();?>administrator/components/com_activategrid/assets/images/logo-small.png" alt="Activate Media Logo" />                    
                    </fieldset>
                </div>
            </div>
        </div>    
    </div>   