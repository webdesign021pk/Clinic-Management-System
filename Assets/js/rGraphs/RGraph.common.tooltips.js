// version: 2020-03-03
    // o--------------------------------------------------------------------------------o
    // | This file is part of the RGraph package - you can learn more at:               |
    // |                                                                                |
    // |                         https://www.rgraph.net                                 |
    // |                                                                                |
    // | RGraph is licensed under the Open Source MIT license. That means that it's     |
    // | totally free to use and there are no restrictions on what you can do with it!  |
    // o--------------------------------------------------------------------------------o

    RGraph = window.RGraph || {isrgraph:true,isRGraph: true,rgraph:true};

// Module pattern
(function (win, doc, undefined)
{
    var ua  = navigator.userAgent;

    //
    // This is used in two functions, hence it's here
    //
    RGraph.tooltips     = {};
    RGraph.tooltips.css = 
    RGraph.tooltips.style = {
        display:    'inline-block',
        position:   'absolute',
        padding:    '6px',
        fontFamily: 'Arial',
        fontSize:   '10pt',
        fontWeight: 'normal',
        textAlign:  'center',
        left:       0,
        top:        0,
        backgroundColor: 'rgb(255,255,239)',
        color:      'black',
        visibility: 'visible',
        zIndex:     3,
        borderRadius: '5px',
        boxShadow:  'rgba(96,96,96,0.5) 0 0 5px',
        opacity:    0,
        lineHeight: RGraph.ISIE ? 'normal' : 'initial'
    };



    //
    // Shows a tooltip next to the mouse pointer
    // 
    // @param object object The canvas element object
    // @param string text   The tooltip text
    // @param int    x      The X position that the tooltip should appear at. Combined with the canvases offsetLeft
    //                      gives the absolute X position
    // @param int    y      The Y position the tooltip should appear at. Combined with the canvases offsetTop
    //                      gives the absolute Y position
    // @param int    index  The index of the tooltip in the graph objects tooltip array
    // @param object event  The event object
    //
    RGraph.tooltip = function ()
    {
        var args = RGraph.getArgs(arguments, 'object,text,x,y,index,event');

        if (RGraph.trim(args.text).length === 0) {
            return;
        }



        //
        // Fire the beforetooltip event
        //
        RGraph.fireCustomEvent(args.object, 'onbeforetooltip');



        //
        // tooltipOverride allows you to totally take control of rendering the tooltip yourself
        //
        if (typeof args.object.get('tooltipsOverride') == 'function') {
            return args.object.get('tooltipsOverride')(
                args.object,
                args.text,
                args.x,
                args.y,
                args.index
            );
        }




        //
        // Save the X/Y coords
        //
        var originalX = args.x;
        var originalY = args.y;

        //
        // This facilitates the "id:xxx" format
        //
        args.text = RGraph.getTooltipTextFromDIV(args.text);

        //
        // First clear any exising timers
        //
        var timers = RGraph.Registry.get('tooltip.timers');

        if (timers && timers.length) {
            for (i=0; i<timers.length; ++i) {
                clearTimeout(timers[i]);
            }
        }
        RGraph.Registry.set('tooltip.timers', []);

        //
        // Hide the context menu if it's currently shown
        //
        if (args.object.get('contextmenu')) {
            RGraph.hideContext();
        }



        //
        // Show a tool tip
        //
        if (typeof args.object.get('tooltipsCssClass') !== 'string' ) {
            args.object.set('tooltipsCssClass', 'RGraph_tooltip');
        }

        var tooltipObj       = document.createElement('DIV');
        tooltipObj.className = args.object.get('tooltipsCssClass');

        // Add the default CSS to the tooltip
        for (var i in RGraph.tooltips.style) {
            if (typeof i === 'string') {
                tooltipObj.style[i] = RGraph.tooltips.style[i];
            }
        }

        for (var i in RGraph.tooltips.css) {
            if (typeof i === 'string') {
                tooltipObj.style[i] = RGraph.tooltips.css[i];
            }
        }

        //
        // If the tooltipsCss property is populated the add those values
        // to the tooltip
        //
        if (!RGraph.isNull(args.object.properties.tooltipsCss)) {
            for (var i in args.object.properties.tooltipsCss) {
                if (typeof i === 'string') {
                    tooltipObj.style[i] = args.object.properties.tooltipsCss[i];
                }
            }
        }


























































        ///////////////////////////////////////
        // Do tooltip text substitution here //
        ///////////////////////////////////////
        function substitute (original)
        {
            var prop = args.object.properties;

            if (typeof args.object.tooltipSubstitutions !== 'function') {
                return original;
            }

            //
            // Get hold of the indexes from the sequentialIndex that we have.
            //
            if (typeof args.object.tooltipSubstitutions === 'function') {
                var specific = args.object.tooltipSubstitutions({
                    index: args.index
                });
            }


            // This allows for escaping the percent
            var text = original.replace(/%%/g, '___--PERCENT--___');

















        //
        // Draws the key in the tooltip
        //
        (function ()
        {
            if (!specific.values) {
                return;
            }
        
            //
            // Allow the user to specify the key colors
            //
            var colors = prop.tooltipsFormattedKeyColors ? prop.tooltipsFormattedKeyColors : prop.colors;
        
            // Build up the HTML table that becomes the key
            for (var i=0,str=[]; i<specific.values.length; ++i) {
        
                var value = (typeof specific.values === 'object' && typeof specific.values[i] === 'number') ? specific.values[i] : 0;
                var color = colors[i];
                var label = ( (typeof prop.tooltipsFormattedKeyLabels === 'object' && typeof prop.tooltipsFormattedKeyLabels[i] === 'string') ? prop.tooltipsFormattedKeyLabels[i] : '');
        
        
        
        
        
        
        
        
                // Chart specific customisations -------------------------
                
                // BAR CHART
                if (args.object.type === 'bar') {
                    if (args.object.stackedOrGrouped) {
                        label = (!RGraph.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && prop.tooltipsFormattedKeyLabels[i])
                                     ? prop.tooltipsFormattedKeyLabels[i]
                                     : '';
        
                    } else {
        
                        label = (   !RGraph.isNull(prop.tooltipsFormattedKeyLabels)
                                 && typeof prop.tooltipsFormattedKeyLabels === 'object'
                                 && prop.tooltipsFormattedKeyLabels[specific.dataset])
                                     ? prop.tooltipsFormattedKeyLabels[specific.dataset]
                                     : '';
                    }
        
        
        
        
                // BIPOLAR CHART
                } else if (args.object.type === 'bipolar') {
                    
                    var side = ((specific.dataset + 1) > args.object.left.length) ? 'right' : 'left';
        
                    if (typeof args.object[side][specific.dataset2] === 'object') {
        
                        label = (!RGraph.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && prop.tooltipsFormattedKeyLabels[i])
                                     ? prop.tooltipsFormattedKeyLabels[i]
                                     : '';
                    } else {
                        label = (!RGraph.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && prop.tooltipsFormattedKeyLabels[specific.dataset2])
                                     ? prop.tooltipsFormattedKeyLabels[specific.dataset2]
                                     : '';
                    }
        
        
        
        
                // FUNNEL CHART
                } else if (args.object.type === 'funnel') {
                    color = prop.colors[specific.index];
                    label = RGraph.isString(prop.tooltipsFormattedKeyLabels[specific.index]) ? prop.tooltipsFormattedKeyLabels[specific.index] : '';;
        
        
        
        
                // HPROGRESS CHART
                } else if (args.object.type === 'hprogress') {
                    color = prop.colors[specific.index];
                    label = RGraph.isString(prop.tooltipsFormattedKeyLabels[specific.index]) ? prop.tooltipsFormattedKeyLabels[specific.index] : '';;
        
        
        
        
                // HBAR CHART
                } else if (args.object.type === 'hbar') {
                    if (args.object.stackedOrGrouped) {
                        label = (!RGraph.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && prop.tooltipsFormattedKeyLabels[i])
                                     ? prop.tooltipsFormattedKeyLabels[i]
                                     : '';
        
                    } else {
                        label = (!RGraph.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && prop.tooltipsFormattedKeyLabels[specific.dataset])
                                     ? prop.tooltipsFormattedKeyLabels[specific.dataset]
                                     : '';//prop.xaxisLabels[specific.dataset];
                    }
        
        
        
        
                // PIE CHART
                } else if (args.object.type === 'pie') {
                    color = colors[specific.index];
                    label = ( (typeof prop.tooltipsFormattedKeyLabels === 'object' && typeof prop.tooltipsFormattedKeyLabels[specific.index] === 'string') ? prop.tooltipsFormattedKeyLabels[specific.index] : '');
        
        
        
        
                // RADAR CHART
                } else if (args.object.type === 'radar') {
        
                    color = (   !RGraph.isNull((prop.tooltipsFormattedKeyColors))
                             && typeof prop.tooltipsFormattedKeyColors === 'object'
                             && prop.tooltipsFormattedKeyColors[i])
                                ? prop.tooltipsFormattedKeyColors[i]
                                : '';
        
                    label = (   !RGraph.isNull((prop.tooltipsFormattedKeyLabels))
                             && typeof prop.tooltipsFormattedKeyLabels === 'object'
                             && prop.tooltipsFormattedKeyLabels[i])
                                ? prop.tooltipsFormattedKeyLabels[i]
                                : '';
        
                
                // ROSE CHART
                } else if (args.object.type === 'rose') {
        
                    color = args.object.properties.colors[i];
                    
                    // Different variations of the Rose chart
                    
                    // REGULAR CHART
                    if (typeof args.object.data[specific.dataset] === 'number') {
                        label = args.object.properties.tooltipsFormattedKeyLabels[specific.dataset] || '';
                    
                    // NON-EQUI-ANGULAR CHART
                    } else if (typeof args.object.data[specific.dataset] === 'object' && args.object.properties.variant === 'non-equi-angular') {
                        // Don't show the second value on a non-equi-angular chart
                        if (i > 0) {
                            continue;
                        }
                        color = colors[specific.index];
                        value = args.object.data[specific.dataset][0];
                    }
        
                    //label = ( (typeof prop.tooltipsFormattedKeyLabels === 'object' && typeof prop.tooltipsFormattedKeyLabels[specific.index] === 'string') ? prop.tooltipsFormattedKeyLabels[specific.index] : '');
        
        
        
        
                // RSCATTER CHART
                } else if (args.object.type === 'rscatter') {
                    
                    color = args.object.data[specific.dataset][specific.index][2] ? args.object.data[specific.dataset][specific.index][2] : prop.colorsDefault;
                    
                    // The tooltipsFormattedKeyColors property has been specified so use that if
                    // there's a relevant color
                    if (!RGraph.isNull(prop.tooltipsFormattedKeyColors) && typeof prop.tooltipsFormattedKeyColors === 'object' && typeof prop.tooltipsFormattedKeyColors[specific.dataset] === 'string') {
                        color = prop.tooltipsFormattedKeyColors[specific.dataset];
                    }
                    
                    // Figure out the correct label to use if one has indeed been specified
                    label = (!RGraph.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && typeof prop.tooltipsFormattedKeyLabels[specific.dataset] === 'string')
                        ? prop.tooltipsFormattedKeyLabels[specific.dataset]
                        : '';
        
        
        
        
                // SCATTER CHART
                } else if (args.object.type === 'scatter') {
                    color = args.object.data[specific.dataset][specific.index][2]
                                ? args.object.data[specific.dataset][specific.index][2]
                                : prop.colorsDefault;
                    
                    // The tooltipsFormattedKeyColors property has been specified so use that if
                    // there's a relevant color
                    if (!RGraph.isNull(prop.tooltipsFormattedKeyColors) && typeof prop.tooltipsFormattedKeyColors === 'object' && typeof prop.tooltipsFormattedKeyColors[specific.dataset] === 'string') {
                        color = prop.tooltipsFormattedKeyColors[specific.dataset];
                    }
        
                    label = prop.tooltipsFormattedKeyLabels[specific.dataset]
                                ? prop.tooltipsFormattedKeyLabels[specific.dataset]
                                : '';
        
        
        
        
                // THERMOMETER CHART
                } else if (args.object.type === 'thermometer') {
                    color = (prop.tooltipsFormattedKeyColors && prop.tooltipsFormattedKeyColors[0]) ? prop.tooltipsFormattedKeyColors[0] : prop.colors[0];
                    label = (prop.tooltipsFormattedKeyLabels && prop.tooltipsFormattedKeyLabels[0]) ? prop.tooltipsFormattedKeyLabels[0] : '';
        
        
        
        
                // VPROGRESS CHART
                } else if (args.object.type === 'vprogress') {
                    color = (prop.tooltipsFormattedKeyColors && prop.tooltipsFormattedKeyColors[specific.index]) ? prop.tooltipsFormattedKeyColors[specific.index] : prop.colors[specific.index];
                    label = (prop.tooltipsFormattedKeyLabels && prop.tooltipsFormattedKeyLabels[specific.index]) ? prop.tooltipsFormattedKeyLabels[specific.index] : '';
        
        
        
        
                // WATERFALL CHART
                } else if (args.object.type === 'waterfall') {
        
                    // Determine the correct color array to use
                    colors = prop.colors;
        
                    if (prop.tooltipsFormattedKeyColors) {
                        colors = prop.tooltipsFormattedKeyColors;
                    }
                    
                    color = colors[0];
                    
                    // Change the color for negative bars
                    if (specific.value < 0) {
                        color = colors[1]; 
                    }
        
                    // Change the color for the last bar
                    if (specific.index == args.object.data.length) {
                        color = colors[2];
                    }
                    
                    // Figure out the correct label
                    if (typeof prop.tooltipsFormattedKeyLabels === 'object' && typeof prop.tooltipsFormattedKeyLabels[specific.index] === 'string') {
                        label = prop.tooltipsFormattedKeyLabels[specific.index];
                    } else if (prop.xaxisLabels && typeof prop.xaxisLabels === 'object' && typeof prop.xaxisLabels[specific.index] === 'string') {
                        label = prop.xaxisLabels[specific.index];
                    }
                }
                // -------------------------------------------------------








        value = RGraph.numberFormat({
            object:    args.object,
            number:    value.toFixed(args.object.properties.tooltipsFormattedDecimals),
            thousand:  args.object.properties.tooltipsFormattedThousand  || ',',
            point:     args.object.properties.tooltipsFormattedPoint     || '.',
            unitspre:  args.object.properties.tooltipsFormattedUnitsPre  || '',
            unitspost: args.object.properties.tooltipsFormattedUnitsPost || ''
        });

        str[i] = '<tr><td><div style="text-align: left; background-color: '
            + color + '; color: transparent; pointer-events: none">Ml</div></td><td style="text-align: left">'
            + label
            + ' ' + value + '</td></tr>';
    }
    str = str.join('');

    // Add the key to the tooltip text - replacing the placeholder
    text = text.replace('%{key}', '<table style="color: inherit" id="rgraph_tooltip_key">' + str + '</table>');
})();











            // Replace the index of the tooltip
            text = text.replace(/%{index}/g, specific.index);
            
            // Replace the dataset/group of the tooltip
            text = text.replace(/%{dataset2}/g, specific.dataset2); // Used by the Bipolar
            text = text.replace(/%{dataset}/g, specific.dataset);
            text = text.replace(/%{group2}/g, specific.dataset2);
            text = text.replace(/%{group}/g, specific.dataset);
            
            // Replace the sequentialIndex of the tooltip
            text = text.replace(/%{sequential_index}/g, specific.sequentialIndex);
            text = text.replace(/%{seq}/g, specific.sequentialIndex);

            // Do property substitution when there's an index to the property
            var reg = /%{prop(?:erty)?:([a-z0-9]+)\[([0-9]+)\]}/i;

            while (text.match(reg)) {

                var property = RegExp.$1;
                var index    = parseInt(RegExp.$2);

                if (args.object.properties[property]) {
                    text = text.replace(
                        reg,
                        args.object.properties[property][index] || ''
                    );

                // Get rid of the text
                } else {
                    text = text.replace(reg,'');
                }
                    
                RegExp.lastIndex = null;
            }




            // Third, replace this: %%property:xxx%%
            while (text.match(/%{property:([a-z0-9]+)}/i)) {
                var str = '%{property:' + RegExp.$1 + '}';
                text    = text.replace(str, args.object.properties[RegExp.$1]);
            }




            // Fourth, replace this: %%prop:xxx%%
            while (text.match(/%{prop:([a-z0-9]+)}/i)) {
                var str = '%{prop:' + RegExp.$1 + '}';
                text    = text.replace(str, args.object.properties[RegExp.$1]);
            }




            // Fifth and sixth, replace this: %{value} and this: %{value_formatted}
            while (text.match(/%{value(?:_formatted)?}/i)) {
                
                var value = specific.value;

                if (text.match(/%{value_formatted}/i)) {
                    text = text.replace(
                        '%{value_formatted}',
                        typeof value === 'number' ? RGraph.numberFormat({
                            object:    args.object,
                            number:    value.toFixed(args.object.properties.tooltipsFormattedDecimals),
                            thousand:  args.object.properties.tooltipsFormattedThousand  || ',',
                            point:     args.object.properties.tooltipsFormattedPoint     || '.',
                            unitspre:  args.object.properties.tooltipsFormattedUnitsPre  || '',
                            unitspost: args.object.properties.tooltipsFormattedUnitsPost || ''
                        }) : null
                    );
                } else {
                    text = text.replace('%{value}', value);
                }
            }

















            // And lastly - call any functions
            // MUST be last
            // NOTE Might be removed
            var regexp = /%{function:([A-Za-z0-9]+)\((.*?)\)}/;
            
            // Temporarily replace carriage returns and line feeds with CR and LF
            // so the the s option is not needed
            text = text.replace(/\r/,'|CR|');
            text = text.replace(/\n/,'|LF|');

            while (text.match(regexp)) {

                var str  = RegExp.$1 + '(' + RegExp.$2 + ')';
                
                for (var i=0,len=str.length; i<len; ++i) {
                    str  = str.replace(/\r?\n/, "\\n");
                }

                var func = new Function ('return ' + str);
                var ret  = func();

                text = text.replace(regexp, ret)
            }

            // Replace CR and LF with a space
            text = text.replace(/\|CR\|/, ' ');
            text = text.replace(/\|LF\|/, ' ');





            
            // Replace line returns with br tags
            text = text.replace(/\r?\n/g, '<br />');
            text = text.replace(/___--PERCENT--___/g, '%')


            return text.toString();
        }

        // Save the original text on the tooltip
        tooltipObj.__original_text__  = args.text;

        args.text = substitute(args.text);






































































        tooltipObj.innerHTML  = args.text;
        tooltipObj.__text__   = args.text; // This is set because the innerHTML can change when it's set
        tooltipObj.__canvas__ = args.object.canvas;
        tooltipObj.id         = '__rgraph_tooltip_' + args.object.canvas.id + '_' + args.object.uid + '_'+ args.index;
        tooltipObj.__event__  = args.object.get('tooltipsEvent') || 'click';
        tooltipObj.__object__ = args.object;

        if (typeof args.index === 'number') {
            tooltipObj.__index__ = args.index;
            origIdx = args.index;
        }

        if (args.object.type === 'line' || args.object.type === 'radar') {
            for (var ds=0; ds<args.object.data.length; ++ds) {
                if (args.index >= args.object.data[ds].length) {
                    args.index -= args.object.data[ds].length;
                } else {
                    break;
                }
            }
            
            tooltipObj.__dataset__ = ds;
            tooltipObj.__index2__  = args.index;
        }

        document.body.appendChild(tooltipObj);
        //obj.canvas.parentNode.appendChild(tooltipObj);

        var width  = tooltipObj.offsetWidth;
        var height = tooltipObj.offsetHeight;


        //
        // Set the width on the tooltip so it doesn't resize if the window is resized
        //
        tooltipObj.style.width = width + 'px';









        //
        // position the tooltip on the mouse pointers position
        //
        var mouseXY  = RGraph.getMouseXY(args.event);
        var canvasXY = RGraph.getCanvasXY(args.object.canvas);

        // Position based on the mouse pointer coords on the page
        tooltipObj.style.left = args.event.pageX - (parseFloat(tooltipObj.style.paddingLeft) + (width / 2)) + 'px';
        tooltipObj.style.top  = args.event.pageY - height - 10 + 'px';
        
        // If the left is less than zero - set it to 5
        if (parseFloat(tooltipObj.style.left) <= 5) {
            tooltipObj.style.left = '5px';
        }
        
        // If the top is less than zero - set it to 5
        if (parseFloat(tooltipObj.style.top) <= 5) {
            tooltipObj.style.top = '5px';
        }

        // If the tooltip goes over the right hand edge then
        // adjust the positioning
        if (parseFloat(tooltipObj.style.left) + parseFloat(tooltipObj.style.width) > window.innerWidth) {
            tooltipObj.style.left  = ''
            tooltipObj.style.right = '5px'
        }
        
        // If the canvas has fixed positioning then set the tooltip position to
        // fixed too
        if (RGraph.isFixed(args.object.canvas)) {
            var scrollTop = window.scrollY || document.documentElement.scrollTop;

            tooltipObj.style.position = 'fixed';
            tooltipObj.style.top = args.event.pageY - scrollTop - height - 10 + 'px';
        }
        
        
        
        
        
        
        // If the effect is fade:
        // Increase the opacity from its default 0 up to 1 - fading the tooltip in
        if (args.object.get('tooltipsEffect') === 'fade') {
            for (var i=1; i<=10; ++i) {
                (function (index)
                {
                    setTimeout(function ()
                    {
                        tooltipObj.style.opacity = index / 10;
                    }, index * 25);
                })(i);
            }
        } else {
            tooltipObj.style.opacity = 1;
        }











        //
        // If the tooltip itself is clicked, cancel it
        //
        tooltipObj.onmousedown = function (e){e.stopPropagation();}
        tooltipObj.onmouseup   = function (e){e.stopPropagation();}
        tooltipObj.onclick     = function (e){if (e.button == 0) {e.stopPropagation();}}







        //
        // Keep a reference to the tooltip in the registry
        //
        RGraph.Registry.set('tooltip', tooltipObj);

        //
        // Fire the tooltip event
        //
        RGraph.fireCustomEvent(args.object, 'ontooltip');
    };








    //
    // 
    //
    RGraph.getTooltipTextFromDIV = function ()
    {
        var args = RGraph.getArgs(arguments, 'text');

        // This regex is duplicated firher down on roughly line 888
        var result = /^id:(.*)/.exec(args.text);

        if (result && result[1] && document.getElementById(result[1])) {
            args.text = document.getElementById(result[1]).innerHTML;
        } else if (result && result[1]) {
            args.text = '';
        }
        
        return args.text;
    };








    //
    // Get the width that is set on the tooltip DIV based on the text
    // that has been given
    //
    RGraph.getTooltipWidth = function ()
    {
        var args = RGraph.getArgs(arguments, 'text,object');

        var div = document.createElement('DIV');
            div.className             = args.object.get('tooltipsCssClass');
            div.style.paddingLeft     = RGraph.tooltips.padding;
            div.style.paddingRight    = RGraph.tooltips.padding;
            div.style.fontFamily      = RGraph.tooltips.font_face;
            div.style.fontSize        = RGraph.tooltips.font_size;
            div.style.visibility      = 'hidden';
            div.style.position        = 'absolute';
            div.style.top            = '300px';
            div.style.left             = 0;
            div.style.display         = 'inline';
            div.innerHTML             = RGraph.getTooltipTextFromDIV(args.text);
        document.body.appendChild(div);

        return div.offsetWidth;
    };








    //
    // Hides the currently shown tooltip
    //
    RGraph.hideTooltip = function ()
    {
        var tooltip = RGraph.Registry.get('tooltip');
        var uid     = arguments[0] && arguments[0].uid ? arguments[0].uid : null;

        if (tooltip && tooltip.parentNode && (!uid || uid == tooltip.__canvas__.uid)) {
            tooltip.parentNode.removeChild(tooltip);
            tooltip.style.display = 'none';                
            tooltip.style.visibility = 'hidden';
            RGraph.Registry.set('tooltip', null);
        }
    };




    //
    // This (as the name suggests preloads any images it can find in the tooltip text
    // 
    // @param object obj The chart object
    //
    RGraph.preLoadTooltipImages = function ()
    {
        var args = RGraph.getArgs(arguments, 'object');

        var tooltips = args.object.get('tooltips');
        
        if (RGraph.hasTooltips(args.object)) {
        
            if (args.object.type == 'rscatter') {
                tooltips = [];
                for (var i=0; i<args.object.data.length; ++i) {
                    tooltips.push(args.object.data[3]);
                }
            }
            
            for (var i=0; i<tooltips.length; ++i) {
                // Add the text to an offscreen DIV tag
                var div = document.createElement('div');
                    div.style.position = 'absolute';
                    div.style.opacity = 0;
                    div.style.top = '-100px';
                    div.style.left = '-100px';
                    div.innerHTML  = tooltips[i];
                document.body.appendChild(div);
                
                // Now get the IMG tags and create them
                var img_tags = div.getElementsByTagName('IMG');
    
                // Create the image in an off-screen image tag
                for (var j=0; j<img_tags.length; ++j) {
                        if (img_tags && img_tags[i]) {
                        var img = document.createElement('img');
                            img.style.position = 'absolute';
                            img.style.opacity = 0;
                            img.style.top = '-100px';
                            img.style.left = '-100px';
                            img.src = img_tags[i].src
                        document.body.appendChild(img);
                        
                        setTimeout(function () {document.body.removeChild(img);}, 250);
                    }
                }
    
                // Now remove the div
                document.body.removeChild(div);
            }
        }
    };








    //
    // This is the tooltips canvas onmousemove listener
    //
    RGraph.tooltips_mousemove = function ()
    {
        var args                  = RGraph.getArgs(arguments, 'object,event'),
            shape                 = args.object.getShape(args.event),
            changeCursor_tooltips = false

        if (   shape
            && typeof shape.index === 'number'
            && args.object.get('tooltips')[shape.index]
           ) {

            var text = RGraph.parseTooltipText(
                args.object.get('tooltips'),
                shape.index
            );

            if (text) {

                //
                // Change the cursor
                //
                changeCursor_tooltips = true;

                if (args.object.get('tooltipsEvent') === 'onmousemove') {

                    // Show the tooltip if it's not the same as the one already visible
                    if (
                           !RGraph.Registry.get('tooltip')
                        || RGraph.Registry.get('tooltip').__object__.uid != args.object.uid
                        || RGraph.Registry.get('tooltip').__index__ != shape.index
                       ) {

                        RGraph.hideTooltip();
                        RGraph.clear(args.object.canvas);
                        RGraph.redraw();
                        RGraph.tooltip(
                            args.object,
                            text,
                            args.event.pageX,
                            args.event.pageY,
                            shape.index
                        );
                        args.object.highlight(shape);
                    }
                }
            }
        
        //
        // More highlighting
        //
        } else if (shape && typeof shape.index === 'number') {

            var text = RGraph.parseTooltipText(
                args.object.get('tooltips'),
                shape.index
            );

            if (text) {
                changeCursor_tooltips = true
            }
        }

        return changeCursor_tooltips;
    };








// End module pattern
})(window, document);