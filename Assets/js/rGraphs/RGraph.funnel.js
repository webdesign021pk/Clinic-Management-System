// version: 2020-03-03
    // o--------------------------------------------------------------------------------o
    // | This file is part of the RGraph package - you can learn more at:               |
    // |                                                                                |
    // |                         https://www.rgraph.net                                 |
    // |                                                                                |
    // | RGraph is licensed under the Open Source MIT license. That means that it's     |
    // | totally free to use and there are no restrictions on what you can do with it!  |
    // o--------------------------------------------------------------------------------o

    RGraph = window.RGraph || {isrgraph:true,isRGraph:true,rgraph:true};

    //
    // The bar chart constructor
    //
    RGraph.Funnel = function (conf)
    {
        var id     = conf.id;
        var canvas = document.getElementById(id);
        var data   = conf.data;

        this.id                = id;
        this.canvas            = canvas;
        this.context           = this.canvas.getContext ? this.canvas.getContext("2d", {alpha: (typeof id === 'object' && id.alpha === false) ? false : true}) : null;
        this.canvas.__object__ = this;
        this.type              = 'funnel';
        this.coords            = [];
        this.isRGraph          = true;
        this.isrgraph          = true;
        this.rgraph            = true;
        this.uid               = RGraph.createUID();
        this.canvas.uid        = this.canvas.uid ? this.canvas.uid : RGraph.createUID();
        this.coordsText        = [];
        this.original_colors   = [];
        this.firstDraw         = true; // After the first draw this will be false

        // Check for support
        if (!this.canvas) {
            alert('[FUNNEL] No canvas support');
            return;
        }

        //
        // The funnel charts properties
        //
        this.properties =
        {
            colorsStroke: 'rgba(0,0,0,0)',
            colors: ['red','green','gray','black','pink','orange','blue','yellow','green','red'],

            marginLeft:           35,
            marginRight:          35,
            marginTop:            35,
            marginBottom:         35,
            
            labels:                null,
            labelsFont:           null,
            labelsSize:           null,
            labelsColor:          null,
            labelsBold:           null,
            labelsItalic:         null,
            labelsSticks:         false,
            labelsX:              null,

            title:                  '',
            titleBackground:       null,
            titleHpos:             null,
            titleVpos:             null,
            titleItalic:           null,
            titleBold:             null,
            titleFont:             null,
            titleSize:             null,
            titleColor:            null,
            titleX:                null,
            titleY:                null,
            titleHalign:           null,
            titleValign:           null,

            textSize:             12,
            textColor:            'black',
            textFont:             'Arial, Verdana, sans-serif',
            textBold:             false,
            textItalic:           false,
            textHalign:           'left',
            textAccessible:               true,
            textAccessibleOverflow:      'visible',
            textAccessiblePointerevents: false,

            contextmenu:           null,

            shadow:                false,
            shadowColor:          '#666',
            shadowBlur:           3,
            shadowOffsetx:        3,
            shadowOffsety:        3,

            key:                    null,
            keyBackground:         'white',
            keyPosition:           'graph',
            keyHalign:             'right',
            keyShadow:             false,
            keyShadowColor:       '#666',
            keyShadowBlur:        3,
            keyShadowOffsetx:     2,
            keyShadowOffsety:     2,
            keyPositionMarginBoxed: false,
            keyPositionX:         null,
            keyPositionY:         null,
            keyColorShape:        'square',
            keyRounded:            true,
            keyLinewidth:          1,
            keyColors:             null,
            keyInteractive:        false,
            keyInteractiveHighlightChartStroke: 'black',
            keyInteractiveHighlightChartFill:   'rgba(255,255,255,0.7)',
            keyInteractiveHighlightLabel:        'rgba(255,0,0,0.2)',
            keyLabelsFont:         null,
            keyLabelsSize:         null,
            keyLabelsColor:        null,
            keyLabelsBold:         null,
            keyLabelsItalic:       null,
            keyLabelsOffsetx:      0,
            keyLabelsOffsety:      0,

            tooltipsHighlight:     true,

            tooltips:                   null,
            tooltipsEffect:             'fade',
            tooltipsCssClass:           'RGraph_tooltip',
            tooltipsCss:                null,
            tooltipsEvent:              'onclick',
            tooltipsFormattedThousand:  ',',
            tooltipsFormattedPoint:     '.',
            tooltipsFormattedDecimals:  0,
            tooltipsFormattedUnitsPre:  '',
            tooltipsFormattedUnitsPost: '',
            tooltipsFormattedKeyColors: null,
            tooltipsFormattedKeyLabels: [],

            highlightStroke:       'rgba(0,0,0,0)',
            highlightFill:         'rgba(255,255,255,0.7)',

            annotatable:           false,
            annotatableColor:     'black',

            resizable:                   false,
            resizableHandleBackground: null,

            clearto:   'rgba(0,0,0,0)'
        }

        // Store the data
        for (var i=0; i<data.length; ++i) {
            data[i] = parseFloat(data[i]);
        }
        this.data = data;


        //
        // Create the dollar objects so that functions can be added to them
        //
        for (var i=0; i<data.length; ++i) {
            this['$' + i] = {};
        }


        //
        // Translate half a pixel for antialiasing purposes - but only if it hasn't beeen
        // done already
        //
        if (!this.canvas.__rgraph_aa_translated__) {
            this.context.translate(0.5,0.5);
            
            this.canvas.__rgraph_aa_translated__ = true;
        }




        // Easy access to  properties and the path function
        var prop  = this.properties;
        this.path = RGraph.pathObjectFunction;
        
        
        
        //
        // "Decorate" the object with the generic effects if the effects library has been included
        //
        if (RGraph.Effects && typeof RGraph.Effects.decorate === 'function') {
            RGraph.Effects.decorate(this);
        }
        
        
        
        // Add the responsive method. This method resides in the common file.
        this.responsive = RGraph.responsive;




        //
        // A setter
        // 
        // @param name  string The name of the property to set
        // @param value mixed  The value of the property
        //
        this.set = function (name)
        {
            var value = typeof arguments[1] === 'undefined' ? null : arguments[1];

            // the number of arguments is only one and it's an
            // object - parse it for configuration data and return.
            if (arguments.length === 1 && typeof arguments[0] === 'object') {
                for (i in arguments[0]) {
                    if (typeof i === 'string') {
                        this.set(i, arguments[0][i]);
                    }
                }

                return this;
            }

            prop[name] = value;

            return this;
        };








        //
        // A getter
        // 
        // @param name  string The name of the property to get
        //
        this.get = function (name)
        {
            return prop[name];
        };








        //
        // The function you call to draw the bar chart
        //
        this.draw = function ()
        {
            // Fire the onbeforedraw event
            RGraph.fireCustomEvent(this, 'onbeforedraw');
    
    
            //
            // Parse the colors. This allows for simple gradient syntax
            //
            if (!this.colorsParsed) {
                this.parseColors();
                
                // Don't want to do this again
                this.colorsParsed = true;
            }



            //
            // Make the margins easy ro access
            //
            this.marginLeft   = prop.marginLeft;
            this.marginRight  = prop.marginRight;
            this.marginTop    = prop.marginTop;
            this.marginBottom = prop.marginBottom;
    
            // This stops the coords array from growing
            this.coords = [];
            
            //
            // Stop this growing uncntrollably
            //
            this.coordsText = [];
    
            RGraph.drawTitle(
                this,
                prop.title,
                this.marginTop,
                null,
                typeof prop.titleSize === 'number' ? prop.titleSize : prop.textSize
            );
            
            this.drawFunnel();

            
            //
            // Setup the context menu if required
            //
            if (prop.contextmenu) {
                RGraph.showContext(this);
            }
    
    
    
            //
            // Draw the labels on the chart
            //
            this.drawLabels();

            
            //
            // This function enables resizing
            //
            if (prop.resizable) {
                RGraph.allowResizing(this);
            }

    
            //
            // This installs the event listeners
            //
            RGraph.installEventListeners(this);


    

            //
            // Fire the onfirstdraw event
            //
            if (this.firstDraw) {
                this.firstDraw = false;
                RGraph.fireCustomEvent(this, 'onfirstdraw');
                this.firstDrawFunc();
            }




            //
            // Fire the RGraph draw event
            //
            RGraph.fireCustomEvent(this, 'ondraw');

            return this;
        };








        //
        // Used in chaining. Runs a function there and then - not waiting for
        // the events to fire (eg the onbeforedraw event)
        // 
        // @param function func The function to execute
        //
        this.exec = function (func)
        {
            func(this);
            
            return this;
        };








        //
        // This function actually draws the chart
        //
        this.drawFunnel = function ()
        {
            var width     = this.canvas.width - this.marginLeft - this.marginRight;
            var height    = this.canvas.height - this.marginTop - this.marginBottom;
            var max       = RGraph.arrayMax(this.data);
            var accheight = this.marginTop;

    
            //
            // Loop through each segment to draw
            //

            // Set a shadow if it's been requested
            if (prop.shadow) {
                this.context.shadowColor   = prop.shadowColor;
                this.context.shadowBlur    = prop.shadowBlur;
                this.context.shadowOffsetX = prop.shadowOffsetx;
                this.context.shadowOffsetY = prop.shadowOffsety;
            }

            for (i=0,len=this.data.length; i<len; ++i) {

                var firstvalue = this.data[0];
                var firstwidth = (firstvalue / max) * width;
                var curvalue   = this.data[i];
                var curwidth   = (curvalue / max) * width;
                var curheight  = height / (this.data.length - 1);
                var halfCurWidth = (curwidth / 2);
                var nextvalue  = this.data[i + 1];
                var nextwidth  = this.data[i + 1] ? (nextvalue / max) * width : null;
                var halfNextWidth = (nextwidth / 2);
                var center        = this.marginLeft + (firstwidth / 2);

                var x1 = center - halfCurWidth;
                var y1 = accheight;
                var x2 = center + halfCurWidth;
                var y2 = accheight;
                var x3 = center + halfNextWidth;
                var y3 = accheight + curheight;
                var x4 = center - halfNextWidth;
                var y4 = accheight + curheight;
    
                if (nextwidth && i < this.data.length - 1) {

                    this.context.beginPath();
    
                        this.context.strokeStyle = prop.colorsStroke;
                        this.context.fillStyle   = prop.colors[i];
    
                        this.context.moveTo(x1, y1);
                        this.context.lineTo(x2, y2);
                        this.context.lineTo(x3, y3);
                        this.context.lineTo(x4, y4);
    
                    this.context.closePath();

                    //
                    // Store the coordinates
                    //
                    this.coords.push([x1, y1, x2, y2, x3, y3, x4, y4]);
                }
    
    
                // The redrawing if the shadow is on will do the stroke
                if (!prop.shadow) {
                    this.context.stroke();
                }
    
                this.context.fill();
    
                accheight += curheight;
            }

            //
            // If the shadow is enabled, redraw every segment, in order to allow for shadows going upwards
            //
            if (prop.shadow) {
            
                RGraph.noShadow(this);
            
                for (i=0; i<this.coords.length; ++i) {
                
                    this.context.strokeStyle = prop.colorsStroke;
                    this.context.fillStyle = prop.colors[i];
            
                    this.context.beginPath();
                        this.context.moveTo(this.coords[i][0], this.coords[i][1]);
                        this.context.lineTo(this.coords[i][2], this.coords[i][3]);
                        this.context.lineTo(this.coords[i][4], this.coords[i][5]);
                        this.context.lineTo(this.coords[i][6], this.coords[i][7]);
                    this.context.closePath();

                    this.context.stroke();
                    this.context.fill();
                }
            }

            //
            // Lastly, draw the key if necessary
            //
            if (prop.key && prop.key.length) {
                RGraph.drawKey(this, prop.key, prop.colors);
            }
        };








        //
        // Draws the labels
        //
        this.drawLabels = function ()
        {
            //
            // Draws the labels
            //
            if (prop.labels && prop.labels.length > 0) {

                var font    = prop.textFont;
                var size    = prop.textSize;
                var color   = prop.textColor;
                var labels  = prop.labels;
                var halign  = prop.textHalign == 'left' ? 'left' : 'center';
    
                // Get the text configuration
                var textConf = RGraph.getTextConf({
                    object: this,
                    prefix: 'labels'
                });

                if (typeof prop.labelsX == 'number') {
                    var x = prop.labelsX;
                } else {
                    var x = halign == 'left' ? (this.marginLeft - 15) : ((this.canvas.width - this.marginLeft - this.marginRight) / 2) + this.marginLeft;
                }

                for (var j=0; j<this.coords.length; ++j) {  // MUST be "j"
    
                    this.context.beginPath();
                    
                    // Set the color back to black
                    this.context.strokeStyle = 'black';
                    this.context.fillStyle = color;
                    
                    // Turn off any shadow
                    RGraph.noShadow(this);
                    
                    var label = labels[j] || '';
    
                    RGraph.text({
                    
                        object: this,

                        font:   textConf.font,
                        size:   textConf.size,
                        color:  textConf.color,
                        bold:   textConf.bold,
                        italic: textConf.italic,

                        x:              x,
                        y:              this.coords[j][1],
                        text:           label,
                        valign:         'center',
                        halign:         halign,
                        bounding:       true,
                        boundingFill:   'rgba(255,255,255,0.7)',
                        boundingStroke: 'rgba(0,0,0,0)',
                        tag:            'labels'
                    });
                    
                    if (prop.labelsSticks && labels[j]) {
                        //
                        // Measure the text
                        //
                        this.context.font = size + 'pt ' + font;
                        var labelWidth    = this.context.measureText(label).width;
        
                        //
                        // Draw the horizontal indicator line
                        //
                        this.context.beginPath();
                            this.context.strokeStyle = 'gray';
                            this.context.moveTo(x + labelWidth + 10, Math.round(this.coords[j][1]));
                            this.context.lineTo(this.coords[j][0] - 10, Math.round(this.coords[j][1]));
                        this.context.stroke();
                    }
                }

                // This draws the last labels if defined
                var lastLabel = labels[j];
    
                if (lastLabel) {

                    RGraph.text({
                    
                        object: this,

                        font:   textConf.font,
                        size:   textConf.size,
                        color:  textConf.color,
                        bold:   textConf.bold,
                        italic: textConf.italic,

                        x:              x,
                        y:              this.coords[j - 1][5],
                        text:           lastLabel,
                        valign:         'center',
                        halign:         halign,
                        bounding:       true,
                        boundingFill:   'rgba(255,255,255,0.7)',
                        boundingStroke: 'rgba(0,0,0,0)',
                        tag:            'labels'
                    });
    
                    if (prop.labelsSticks) {

                        // Measure the text
                        this.context.font = size + 'pt ' + font;
                        var labelWidth    = this.context.measureText(lastLabel).width;

                        // Draw the horizontal indicator line
                        this.context.beginPath();
                            this.context.strokeStyle = 'gray';

                            //this.context.moveTo(x + labelWidth + 10, Math.round(this.coords[j][1]));
                            //this.context.lineTo(this.coords[j][0] - 10, Math.round(this.coords[j][1]));
                            
                            this.context.moveTo(x + labelWidth + 10, Math.round(this.coords[j - 1][7]));
                            this.context.lineTo(this.coords[j - 1][6] - 10, Math.round(this.coords[j - 1][7]));
                        this.context.stroke();
                    }
                }
            }
        };








        //
        // Gets the appropriate segment that has been highlighted
        //
        this.getShape = function (e)
        {
            var coords      = this.coords;
            var mouseCoords = RGraph.getMouseXY(e);
            var x           = mouseCoords[0];
            var y           = mouseCoords[1];        
    
            for (i=0,len=coords.length; i<len; ++i) {
            
                var segment = coords[i]
    
                // Path testing
                this.context.beginPath();
                    this.context.moveTo(segment[0], segment[1]);
                    this.context.lineTo(segment[2], segment[3]);
                    this.context.lineTo(segment[4], segment[5]);
                    this.context.lineTo(segment[6], segment[7]);
                    this.context.lineTo(segment[8], segment[9]);
    
                if (this.context.isPointInPath(x, y)) {
                    
                    if (RGraph.parseTooltipText && prop.tooltips) {
                        var tooltip = RGraph.parseTooltipText(prop.tooltips, i);
                    }
                    
                    return {
                        object: this,
                        coords: segment,
                       dataset: 0,
                         index: i,
               sequentialIndex: i,
                       tooltip: typeof tooltip === 'string' ? tooltip : null
                    };
                }
            }
    
            return null;
        };








        //
        // Each object type has its own Highlight() function which highlights the appropriate shape
        // 
        // @param object shape The shape to highlight
        //
        this.highlight = function (shape)
        {
            if (prop.tooltipsHighlight) {
            
                if (typeof prop.highlightStyle === 'function') {
                    (prop.highlightStyle)(shape);
                    return;
                }



                var coords = shape.coords;
                
                this.path(
                    'b m % % l % % l % % l % % c s % f %',
                    coords[0], coords[1],
                    coords[2], coords[3],
                    coords[4], coords[5],
                    coords[6], coords[7],
                    prop.highlightStroke,
                    prop.highlightFill
                );
            }
        };








        //
        // The getObjectByXY() worker method. Don't call this call:
        // 
        // RGraph.ObjectRegistry.getObjectByXY(e)
        // 
        // @param object e The event object
        //
        this.getObjectByXY = function (e)
        {
            var mouseXY = RGraph.getMouseXY(e);
    
            if (
                   mouseXY[0] > prop.marginLeft
                && mouseXY[0] < (this.canvas.width - prop.marginRight)
                && mouseXY[1] > prop.marginTop
                && mouseXY[1] < (this.canvas.height - prop.marginBottom)
                ) {
    
                return this;
            }
        };








        //
        // This allows for easy specification of gradients
        //
        this.parseColors = function ()
        {
            var prop = this.properties;

            // Save the original colors so that they can be restored when the canvas is reset
            if (this.original_colors.length === 0) {
                this.original_colors.colors          = RGraph.arrayClone(prop.colors);
                this.original_colors.keyColors       = RGraph.arrayClone(prop.keyColors);
                this.original_colors.highlightFill   = RGraph.arrayClone(prop.highlightFill);
                this.original_colors.highlightStroke = RGraph.arrayClone(prop.highlightStroke);
                this.original_colors.colorsStroke    = RGraph.arrayClone(prop.colorsStroke);
            }

            var colors = prop.colors;
    
            for (var i=0; i<colors.length; ++i) {
                colors[i] = this.parseSingleColorForHorizontalGradient(colors[i]);
            }
            
            var keyColors = prop.keyColors;
            if (keyColors) {
                for (var i=0; i<keyColors.length; ++i) {
                    keyColors[i] = this.parseSingleColorForHorizontalGradient(keyColors[i]);
                }
            }
            
            
            prop.colorsStroke    = this.parseSingleColorForVerticalGradient(prop.colorsStroke);
            prop.highlightStroke = this.parseSingleColorForHorizontalGradient(prop.highlightStroke);
            prop.highlightFill   = this.parseSingleColorForHorizontalGradient(prop.highlightFill);
        };








        //
        // Use this function to reset the object to the post-constructor state. Eg reset colors if
        // need be etc
        //
        this.reset = function ()
        {
        };








        //
        // This parses a single color value
        //
        this.parseSingleColorForHorizontalGradient = function (color)
        {
            if (!color || typeof color != 'string') {
                return color;
            }

            if (color.match(/^gradient\((.*)\)$/i)) {

                // Allow for JSON gradients
                if (color.match(/^gradient\(({.*})\)$/i)) {
                    return RGraph.parseJSONGradient({object: this, def: RegExp.$1});
                }

                var parts = RegExp.$1.split(':');
    
                // Create the gradient
                var grad = this.context.createLinearGradient(prop.marginLeft,0,this.canvas.width - prop.marginRight,0);

                var diff = 1 / (parts.length - 1);
    
                grad.addColorStop(0, RGraph.trim(parts[0]));
    
                for (var j=1; j<parts.length; ++j) {
                    grad.addColorStop(j * diff, RGraph.trim(parts[j]));
                }
            }
                
            return grad ? grad : color;
        };








        //
        // This parses a single color value
        //
        this.parseSingleColorForVerticalGradient = function (color)
        {
            if (!color || typeof color != 'string') {
                return color;
            }
    
            if (color.match(/^gradient\((.*)\)$/i)) {
                
                var parts = RegExp.$1.split(':');
    
                // Create the gradient
                var grad = this.context.createLinearGradient(0, prop.marginTop,0,this.canvas.height - prop.marginBottom);
    
                var diff = 1 / (parts.length - 1);
    
                grad.addColorStop(0, RGraph.trim(parts[0]));
    
                for (var j=1; j<parts.length; ++j) {
                    grad.addColorStop(j * diff, RGraph.trim(parts[j]));
                }
            }

            return grad ? grad : color;
        };








        //
        // This function handles highlighting an entire data-series for the interactive
        // key
        // 
        // @param int index The index of the data series to be highlighted
        //
        this.interactiveKeyHighlight = function (index)
        {
            var coords = this.coords[index];
            
            if (coords && coords.length == 8) {
                var pre_linewidth = this.context.lineWidth;

                this.context.lineWidth   = 2;
                this.context.strokeStyle = prop.keyInteractiveHighlightChartStroke;
                this.context.fillStyle   = prop.keyInteractiveHighlightChartFill;
                
                this.context.beginPath();
                    this.context.moveTo(coords[0], coords[1]);
                    this.context.lineTo(coords[2], coords[3]);
                    this.context.lineTo(coords[4], coords[5]);
                    this.context.lineTo(coords[6], coords[7]);
                this.context.closePath();
                this.context.fill();
                this.context.stroke();
                
                // Reset the linewidth
                this.context.lineWidth = pre_linewidth;
            }
        };








        //
        // Using a function to add events makes it easier to facilitate method chaining
        // 
        // @param string   type The type of even to add
        // @param function func 
        //
        this.on = function (type, func)
        {
            if (type.substr(0,2) !== 'on') {
                type = 'on' + type;
            }
            
            if (typeof this[type] !== 'function') {
                this[type] = func;
            } else {
                RGraph.addCustomEventListener(this, type, func);
            }
    
            return this;
        };








        //
        // This function runs once only
        // (put at the end of the file (before any effects))
        //
        this.firstDrawFunc = function ()
        {
        };








        //
        // A worker function that handles Bar chart specific tooltip substitutions
        //
        this.tooltipSubstitutions = function (opt)
        {
            return {
                  index: opt.index,
                dataset: 0,
        sequentialIndex: opt.index,
                  value: this.data[opt.index],
                 values: [this.data[opt.index]]
            };
        };








        //
        // Always now regsiter the object
        //
        RGraph.register(this);








        //
        // This is the 'end' of the constructor so if the first argument
        // contains configuration data - handle that.
        //
        RGraph.parseObjectStyleConfig(this, conf.options);
    };