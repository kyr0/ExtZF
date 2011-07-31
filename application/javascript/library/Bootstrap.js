/**
 * @class Extzf.Bootstrap
 * @singleton Bootstrap class to initialize the JavaScript core.
 */
Ext.define('Extzf.Bootstrap', {
    
    singleton : true,
    
    /**
     * Runs the boostrap methods to set up the core.
     * 
     * @return {void}
     */
    run : function() {
        
        // Inject prototype extensions
        this.registerPrototypeExtensions();
    
        // Register stateful state management
        this.registerStateProvider();
    
        // Second to happen - Ext.Direct calls won't route well until now
        this.allowModularizedDirectCalls();
    },
    
    /**
     * Appends a method to the String prototype which upper-cases the first
     * character.
     * 
     * @return {void}
     */
    registerPrototypeExtensions : function() {
    
        // Upper case the first character
        String.prototype.ucFirst = function() {
            return this.charAt(0).toUpperCase() + this.substr(1);
        };
    },
    
    
    /**
     * Registers a state provider
     * @return void
     */
    registerStateProvider: function() {
        
        try {
            
            // If LocalStorage is not supported, just use cookies instead
            Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
            
        } catch(e) {
            
            
        }
    },

    
    /**
     * An override for the RemotingProvider standard behaviour to support the module
     * layer of the Zend Framework MVC to get the requests routed nicely.
     * 
     * @return {void}
     */
    allowModularizedDirectCalls : function() {
    
        // Override default behaviour
        Ext.override(Ext.direct.RemotingProvider, {
                        
            getCallData : function(t) {
    
                var module = t.provider.namespace.REMOTING_API.namespace;
                module = module.split('.');
                module = module[1];
    
                return {
                    action : t.action,
                    method : t.method,
                    data : t.data,
                    module : module,
                    type : 'rpc',
                    tid : t.id
                };
            }
        });
    }
});