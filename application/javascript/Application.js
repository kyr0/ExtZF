/**
 * Application base MVC config
 */
Ext.application({
    
    name: 'Extzf',

    appFolder: 'modules',

    /**
     * Auto-initialize the following controllers
     */
    controllers: [
        'Core'
    ],
    
    
    /**
     * @var Extzf.view.Viewport Viewport reference
     */
    viewport: null,
    

    /**
     * Gets called when Ext.onReady() is called (app ready)
     * @return void
     */
    launch: function() {

        // Store reference of application globally
        // (will be needed for controller instantiation later)
        Extzf.Application = this;
        
        Extzf.debug('Starting app!');
        
        // Run the bootstrap process
        Extzf.Bootstrap.run();
        
        // Show the global Extzf viewport
        this.viewport = Ext.create('Extzf.view.Viewport');
        this.viewport.show();
    }
});