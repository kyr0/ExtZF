/**
 * @class Extzf.view.Viewport Application base viewport class
 */
Ext.define('Extzf.view.Viewport', {
    
    extend: 'Ext.container.Viewport',
    layout: 'fit',
    id: 'viewport',
    stateId: 'extzf-viewport',
    stateful: true,
    
    
    /**
     * Checks for browser (mobile or web) to either apply the mobile
     * or the web layouting.
     * @return void
     */
    initComponent: function() {
        
        if (Ext.is.Phone || Ext.is.Tablet) {
            
            Extzf.log('Running in mobile UI!');
            this.buildMobileUI();
        } else {
            
            Extzf.log('Running in web UI!');
            this.buildWebUI();
        }
        
        // Call parent contructor afterwards!
        this.callParent(arguments);
    },
    
    
    /**
     * Building web UI
     * @return void
     */
    buildWebUI: function() {
        
        // Viewport items
        this.items = [{
            xtype: 'container',
            layout: 'border',
            items: [{
                xtype: 'extzf_core_header'
            }, {
                xtype: 'container',
                region: 'center',
                layout: 'fit',
                id: 'extzf-contentpanel',
                items: [{
                    xtype: 'extzf-core-newspanel'
                }]
            }]
        }];
    },
    
    
    /**
     * Building mobile UI
     * @return void
     */
    buildMobileUI: function() {
        this.html = "Mobile UI is not implemented yet, sorry!";
    }    
});
