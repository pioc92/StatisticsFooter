Original Plugin by @peregrine, Redistributed by VrijVlinder with Peregrine's permission. Update by me to support vanilla 2.5
Thanks for using the Plugin.

Please go to the settings page in the dashboard for this plugin.
It is always a good idea to disable the plugin and then update to new version, and then re-enable, and check settings.


the default Refresh of counts is made every 60 seconds - you can change the rate to what you like via config.php

     // e.g. 300 seconds (5 minutes)
     e.g. $Configuration['Plugins']['StatisticsFooter']['Refresh'] = '300';
    // e.g. 30 seconds
     e.g. $Configuration['Plugins']['StatisticsFooter']['Refresh'] = '30';
