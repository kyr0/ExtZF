Ext.ns('Extzf');

/**
 * A timing related method to execude code,
 * when an object is declared
 *
 * @param {Object} obj Object to check in interval
 * @param {Function} fn Function to execute
 * @param {Object} scope Scope if set (Optional)
 * @return {void}
 */
Extzf.whenDefined = function(obj, fn){
    
    var declInterval = setInterval(function(){
    
        if (Ext.isDefined(obj) && obj !== null) {
        
            clearInterval(declInterval);
            
            if (Ext.isDefined(arguments[2])) {
                fn = fn.createDelegate(arguments[2]);
            }
            fn();
        }
        
    }, 50);
};


/**
 * Translates a class by overriding
 * 
 * Example:
 *     Extzf.trCls(Ext.LoadMask, {
 *         msg: Extzf.i18n.loadMaskMsg
 *     });
 *
 * @param {Object} origClass Class prototype object
 * @param {Object} transObj  Object holding translation values
 * @return {void}
 */
Extzf.trCls = function(origClass, transObj){

    if (Ext.isDefined(origClass)) {
        Ext.override(origClass, transObj);
    }
};


/**
 * Translates a text
 * 
 * Example:
 *     Extzf.tr('loadMaskMsg');
 * 
 * @param {String} text Text to translate
 * @return {String} Translated text
 */
Extzf.tr = function(text) {
  
    if (typeof Extzf.i18n[text] != "undefined") {
        return Extzf.i18n[text];
    } else {
        return text;
    } 
};


/**
 * Clones an object
 * @param {Object} obj Object to clone
 * @return {Object} Cloned object instance
 */
Extzf.clone = function(obj) {
    
    function c(obj) {
        for (var i in obj) {
            this[i] = obj[i];
        }
    };
    return new c(obj);
};


/**
 * Log
 * @param {Object} data
 */
Extzf.log = function(data) {
    
    if (typeof console != "undefined" &&
        typeof console.log != "undefined") {
        console.log(data);
    }
};


/**
 * Debug
 * @param {Object} data
 */
Extzf.debug = function(data) {
    
    if (typeof console != "undefined" &&
        typeof console.debug != "undefined") {
        console.debug(data);
    } else {
        Extzf.log(data);
    }
};


/**
 * Dir 
 * @param {Object} data
 */
Extzf.dir = function(data) {
    
    if (typeof console != "undefined" &&
        typeof console.dir != "undefined") {
        console.dir(data);
    } else {
        Extzf.log(data);
    }
};


/**
 * Creates an instance of the controller defined by name
 * @param {String} controllerName Name of the controller to create
 * @return {Ext.app.Controller}
 */
Extzf.loadController = function(controllerName) {

    var controllerClassName = "Extzf.controller." + controllerName;
    var controllerInst = Ext.create(controllerClassName);
    controllerInst.application = Extzf.Application;
    controllerInst.init(
        Ext.decode(Extzf.FrontController.params)
    );
};