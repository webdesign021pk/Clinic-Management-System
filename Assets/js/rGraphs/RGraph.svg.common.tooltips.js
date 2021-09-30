// version: 2020-03-03
    // o--------------------------------------------------------------------------------o
    // | This file is part of the RGraph package - you can learn more at:               |
    // |                                                                                |
    // |                         https://www.rgraph.net                                 |
    // |                                                                                |
    // | RGraph is licensed under the Open Source MIT license. That means that it's     |
    // | totally free to use and there are no restrictions on what you can do with it!  |
    // o--------------------------------------------------------------------------------o

    RGraph     = window.RGraph || {isrgraph:true,isRGraph:true,rgraph:true};
    RGraph.SVG = RGraph.SVG || {};

// Module pattern
(function (win, doc, undefined)
{
    //
    // This is used in two functions, hence it's here
    //
    RGraph.SVG.tooltips       = {};
    RGraph.SVG.tooltips.css =
    RGraph.SVG.tooltips.style = {
        display:    'inline-block',
        position:   'absolute',
        padding:    '6px',
        lineHeight: 'initial',
        fontFamily: 'Arial',
        fontSize:   '12pt',
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
        transition: 'left ease-out .25s, top ease-out .25s'
    };


    //
    // Shows a tooltip
    //
    // @param obj The chart object
    // @param opt The options
    //
    RGraph.SVG.tooltip = function (opt)
    {
        var obj = opt.object;

        // Fire the beforetooltip event
        RGraph.SVG.fireCustomEvent(obj, 'onbeforetooltip');


        if (!opt.text || typeof opt.text === 'undefined' || RGraph.SVG.trim(opt.text).length === 0) {
            return;
        }



        var prop = obj.properties;



        //
        // chart.tooltip.override allows you to totally take control of rendering the tooltip yourself
        //
        if (typeof prop.tooltipsOverride === 'function') {

            // Add the body click handler that clears the highlight if necessary
            //
            document.body.addEventListener('mouseup', function (e)
            {
                obj.removeHighlight();
            }, false);

            return (prop.tooltipsOverride)(obj, opt);
        }







        // Create the tooltip DIV element
        if (!RGraph.SVG.REG.get('tooltip')) {

            var tooltipObj        = document.createElement('DIV');
            tooltipObj.className  = prop.tooltipsCssClass;
    
    
    
    
            // Add the default CSS to the tooltip
            for (var i in RGraph.SVG.tooltips.style) {
                if (typeof i === 'string') {
                    tooltipObj.style[i] = RGraph.SVG.tooltips.style[i];
                }
            }

            for (var i in RGraph.SVG.tooltips.css) {
                if (typeof i === 'string') {
                    tooltipObj.style[i] = RGraph.SVG.tooltips.css[i];
                }
            }
            
            //
            // If the tooltipsCss property is populated the add those values
            // to the tooltip
            //
            if (!RGraph.SVG.isNull(obj.properties.tooltipsCss)) {
                for (var i in obj.properties.tooltipsCss) {
                    if (typeof i === 'string') {
                        tooltipObj.style[i] = obj.properties.tooltipsCss[i];
                    }
                }
            }




        // Reuse an existing tooltip
        } else {
            var tooltipObj = RGraph.SVG.REG.get('tooltip');
            tooltipObj.__object__.removeHighlight();
            
            // This prevents the object from continuously growing
            tooltipObj.style.width = '';
        }




        if (RGraph.SVG.REG.get('tooltip-lasty')) {
            tooltipObj.style.left = RGraph.SVG.REG.get('tooltip-lastx') + 'px';
            tooltipObj.style.top  = RGraph.SVG.REG.get('tooltip-lasty') + 'px';
        }




































        ///////////////////////////////////////
        // Do tooltip text substitution here //
        ///////////////////////////////////////
        function substitute (original)
        {

            if (typeof opt.object.tooltipSubstitutions !== 'function') {
                return original;
            }

            // Get hold of the indexes from the sequentialIndex that we have.
            //
            if (typeof opt.object.tooltipSubstitutions === 'function') {
                var specific = opt.object.tooltipSubstitutions({
                    index: opt.sequentialIndex
                });
            }


            // This allows for escaping the percent
            var text = original.replace(/%%/g, '___--PERCENT--___')


//
// Draws the key in the tooltip
//
var keyReplacementFunction = function ()
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
        if (opt.object.type === 'bar') {
            if (typeof opt.object.data[0] === 'object') {
                label = (!RGraph.SVG.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && prop.tooltipsFormattedKeyLabels[i])
                             ? prop.tooltipsFormattedKeyLabels[i]
                             : '';

            } else {
                label = (   !RGraph.SVG.isNull(prop.tooltipsFormattedKeyLabels)
                         && typeof prop.tooltipsFormattedKeyLabels === 'object'
                         && prop.tooltipsFormattedKeyLabels[specific.dataset])
                             ? prop.tooltipsFormattedKeyLabels[specific.dataset]
                             : '';
            }




        // BIPOLAR CHART
        } else if (opt.object.type === 'bipolar') {
            
            var side = ((specific.dataset + 1) > opt.object.left.length) ? 'right' : 'left';

            color = (!RGraph.isNull(prop.tooltipsFormattedKeyColors) && typeof prop.tooltipsFormattedKeyColors === 'object' && prop.tooltipsFormattedKeyColors[i])
                        ? prop.tooltipsFormattedKeyColors[i]
                        : prop.colors[i];

            if (typeof opt.object[side][specific.dataset2] === 'object') {

                label = (!RGraph.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && prop.tooltipsFormattedKeyLabels[i])
                             ? prop.tooltipsFormattedKeyLabels[i]
                             : '';
            } else {
                label = (!RGraph.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && prop.tooltipsFormattedKeyLabels[specific.dataset2])
                             ? prop.tooltipsFormattedKeyLabels[specific.dataset2]
                             : '';
            }




            // FUNNEL CHART
            } else if (opt.object.type === 'funnel') {
                color = colors[specific.index];
                label = ( (typeof prop.tooltipsFormattedKeyLabels === 'object' && typeof prop.tooltipsFormattedKeyLabels[specific.index] === 'string') ? prop.tooltipsFormattedKeyLabels[specific.index] : '');




            // HBAR CHART
            } else if (opt.object.type === 'hbar') {
                if (typeof opt.object.data[0] === 'object') {
                    label = (!RGraph.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && prop.tooltipsFormattedKeyLabels[i])
                                 ? prop.tooltipsFormattedKeyLabels[i]
                                 : '';
    
                } else {
                    label = (!RGraph.SVG.isNull(prop.tooltipsFormattedKeyLabels) && typeof prop.tooltipsFormattedKeyLabels === 'object' && prop.tooltipsFormattedKeyLabels[specific.dataset])
                                 ? prop.tooltipsFormattedKeyLabels[specific.dataset]
                                 : '';
                }




            // PIE CHART
            } else if (opt.object.type === 'pie') {
                color = colors[specific.index];
                label = ( (typeof prop.tooltipsFormattedKeyLabels === 'object' && typeof prop.tooltipsFormattedKeyLabels[specific.index] === 'string') ? prop.tooltipsFormattedKeyLabels[specific.index] : '');




            // SEMI-CIRCULAR PROGRESS
            } else if (opt.object.type === 'semicircularprogress') {
                color = colors[0];
                label = ( (typeof prop.tooltipsFormattedKeyLabels === 'object' && typeof prop.tooltipsFormattedKeyLabels[0] === 'string') ? prop.tooltipsFormattedKeyLabels[0] : '');
    
    
    
            // RADAR CHART
            } else if (opt.object.type === 'radar') {
                // Seems not to be necessary
                //color = (!RGraph.isNull(prop.tooltipsFormattedKeyColors) && typeof prop.tooltipsFormattedKeyColors === 'object' && prop.tooltipsFormattedKeyColors[i])
                //           ? prop.tooltipsFormattedKeyColors[i]
                //            : '';




            // ROSE CHART
            } else if (opt.object.type === 'rose') {
    
                color = opt.object.properties.colors[i];
    
                // Different variations of the Rose chart
    
                // REGULAR CHART
                if (typeof opt.object.data[specific.dataset] === 'number') {
                    label = opt.object.properties.tooltipsFormattedKeyLabels[specific.dataset] || '';
                
                // NON-EQUI-ANGULAR CHART
                } else if (typeof opt.object.data[specific.dataset] === 'object' && opt.object.properties.variant === 'non-equi-angular') {
    
                    // NON-EQUI-ANGULAR
                    if (RGraph.isNumber(opt.object.data[specific.dataset][0])) {
                        
                        // Don't show the second value on a non-equi-angular chart
                        if (i > 0) {
                            continue;
                        }
    
                        color = colors[specific.index];
                        value = opt.object.data[specific.index][0];
                        label = prop.tooltipsFormattedKeyLabels[specific.dataset];//opt.object.data[specific.index][0];
                    
                    // NON-EQUI-ANGULAR STACKED
                    } else if (RGraph.isArray(opt.object.data[specific.dataset][0])) {
                        color = colors[i];
                        value = opt.object.data[specific.dataset][0][i];
                        label = prop.tooltipsFormattedKeyLabels[i];
                    }
                }
    
                //label = ( (typeof prop.tooltipsFormattedKeyLabels === 'object' && typeof prop.tooltipsFormattedKeyLabels[specific.index] === 'string') ? prop.tooltipsFormattedKeyLabels[specific.index] : '');
    
    
    
    
            // SCATTER CHART
            } else if (opt.object.type === 'scatter') {
                color = opt.object.data[specific.dataset][specific.index].color
                            ? opt.object.data[specific.dataset][specific.index].color
                            : prop.colorsDefault;
                label = prop.tooltipsFormattedKeyLabels[specific.dataset]
                            ? prop.tooltipsFormattedKeyLabels[specific.dataset]
                            : '';
    



            // WATERFALL CHART
            } else if (opt.object.type === 'waterfall') {
            
                //
                // Check for null values (ie subtotals) and calculate the subtotal if required
                //
            
                // Determine the correct color to use
                colors = prop.colors;
            
                if (   prop.tooltipsFormattedKeyColors
                    && prop.tooltipsFormattedKeyColors[0]
                    && prop.tooltipsFormattedKeyColors[1]
                    && prop.tooltipsFormattedKeyColors[2]) {
            
                    colors = prop.tooltipsFormattedKeyColors;
                } else {
                    colors = prop.colors;
                }
                
                color  = colors[0];
            
                // Change the color for negative bars
                if (specific.value < 0) {
                    color = colors[1];
                }
            
                // Change the color for the last bar
                if ( (specific.index + 1) === opt.object.data.length || RGraph.SVG.isNull(opt.object.data[specific.index])) {
                    color = colors[2];
                }
    
    
    
    
                // Figure out the correct label
                if (prop.tooltipsFormattedKeyLabels && typeof prop.tooltipsFormattedKeyLabels === 'object') {
                
                    var isLast      = specific.index === (opt.object.data.length - 1);
                    var isNull      = RGraph.SVG.isNull(opt.object.data[specific.index]);
                    var isPositive  = specific.value > 0;
                    var isNegative  = specific.value < 0;
    
                    if (isLast) {
                        label = typeof prop.tooltipsFormattedKeyLabels[2] === 'string' ? prop.tooltipsFormattedKeyLabels[2] : '';
                    } else if (!isLast && isNull) {
                        label = typeof prop.tooltipsFormattedKeyLabels[3] === 'string' ? prop.tooltipsFormattedKeyLabels[3] : '';
                    } else if (typeof prop.tooltipsFormattedKeyLabels[0] === 'string' && isPositive && !isLast) {
                        label = prop.tooltipsFormattedKeyLabels[0];
                    } else if (typeof prop.tooltipsFormattedKeyLabels[1] === 'string' && isNegative) {
                        label = prop.tooltipsFormattedKeyLabels[1];
                    } else if (typeof prop.tooltipsFormattedKeyLabels[2] === 'string' && isLast) {
                        label = prop.tooltipsFormattedKeyLabels[2];
                    }
                }
    
    
    
    
    
                //
                // Calculate the subtotal for null values which are
                // within the dataset
                //
                if (RGraph.SVG.isNull(opt.object.data[specific.index])) {
                    
                    // Calculate the total thus far
                    for (var i=0,value=0; i<=specific.index; ++i) {
    
                        value += opt.object.data[i];
                    }
                }
            }








        value = RGraph.SVG.numberFormat({
             object: opt.object,
                num: value.toFixed(opt.object.properties.tooltipsFormattedDecimals),
           thousand: opt.object.properties.tooltipsFormattedThousand  || ',',
              point: opt.object.properties.tooltipsFormattedPoint     || '.',
            prepend: opt.object.properties.tooltipsFormattedUnitsPre  || '',
             append: opt.object.properties.tooltipsFormattedUnitsPost || ''
        });

        str[i] = '<tr><td><div style="text-align: left; background-color: '
            + color + '; color: transparent; pointer-events: none">Ml</div></td><td style="text-align: left">'
            + label
            + ' ' + value + '</td></tr>';
    }
    str = str.join('');

    // Add the key to the tooltip text - replacing the placeholder
    text = text.replace('%{key}', '<table style="color: inherit">' + str + '</table>');
};

keyReplacementFunction();













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

                if (opt.object.properties[property]) {
                    text = text.replace(
                        reg,
                        opt.object.properties[property][index] || ''
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
                text    = text.replace(str, opt.object.properties[RegExp.$1]);
            }




            // Fourth, replace this: %%prop:xxx%%
            while (text.match(/%{prop:([a-z0-9]+)}/i)) {
                var str = '%{prop:' + RegExp.$1 + '}';
                text    = text.replace(str, opt.object.properties[RegExp.$1]);
            }





            // Fifth and sixth, replace this: %{value} and this: %{value_formatted}
            while (text.match(/%{value(?:_formatted)?}/i)) {
                
                var value = specific.value;
                
                //
                // Special case for the Waterfall chart and mid totals
                //
                if (opt.object.type === 'waterfall' && specific.index != opt.object.data.length - 1 && RGraph.SVG.isNull(value)) {
                    
                    for (var i=0,tot=0; i<specific.index; ++i) {
                        tot += opt.object.data[i];
                    }
                    value = tot;
                }

                if (text.match(/%{value_formatted}/i)) {
                    text = text.replace(
                        '%{value_formatted}',
                        typeof value === 'number' ? RGraph.numberFormat({
                            object:    opt.object,
                            number:    value.toFixed(opt.object.properties.tooltipsFormattedDecimals),
                            thousand:  opt.object.properties.tooltipsFormattedThousand  || ',',
                            point:     opt.object.properties.tooltipsFormattedPoint     || '.',
                            unitspre:  opt.object.properties.tooltipsFormattedUnitsPre  || '',
                            unitspost: opt.object.properties.tooltipsFormattedUnitsPost || ''
                        }) : null
                    );
                } else {
                    text = text.replace('%{value}', value);
                }
            }







            // And lastly - call any functions
            // MUST be last
            // NOTE Might be removed
            var regexp = new RegExp(/%{function:([A-Za-z0-9]+)\((.*?)\)}/, 's');

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
        tooltipObj.__original_text__  = opt.text;

        opt.text = substitute(opt.text);



















        tooltipObj.innerHTML  = opt.text;
        tooltipObj.__text__   = opt.text; // This is set because the innerHTML can change when it's set
        tooltipObj.id         = '__rgraph_tooltip_' + obj.id + '_' + obj.uid + '_'+  opt.index;
        tooltipObj.__event__  = prop.tooltipsEvent || 'click';
        tooltipObj.__object__ = obj;

        // Add the index
        if (typeof opt.index === 'number') {
            tooltipObj.__index__ = opt.index;
        }

        // Add the dataset
        if (typeof opt.dataset === 'number') {
            tooltipObj.__dataset__ = opt.dataset;
        }

        // Add the group
        if (typeof opt.group === 'number' || RGraph.SVG.isNull(opt.group)) {
            tooltipObj.__group__ = opt.group;
        }

        // Add the sequentialIndex
        if (typeof opt.sequentialIndex === 'number') {
            tooltipObj.__sequentialIndex__ = opt.sequentialIndex;
        }




        // Add the tooltip to the document
        document.body.appendChild(tooltipObj);
        
        
        var width  = tooltipObj.offsetWidth,
            height = tooltipObj.offsetHeight;

        // Move the tooltip into position
        tooltipObj.style.left = opt.event.pageX - (width / 2) + 'px';
        
        // Prevent the top of the tooltip from being placed off the top of the page
        var y = opt.event.pageY - height - 15;
        
        if (y < 0) {
            y = 5;
        }

        tooltipObj.style.top  = y + 'px';




        //
        // Set the width on the tooltip so it doesn't resize if the window is resized
        //
        tooltipObj.style.width = width + 'px';

        // Fade the tooltip in if the tooltip is the first view
        //if (!RGraph.SVG.REG.get('tooltip-lastx')) {
        //    for (var i=0; i<=30; ++i) {
        //        (function (idx)
        //        {
        //            setTimeout(function ()
        //            {
        //                tooltipObj.style.opacity = (idx / 30) * 1;
        //            }, (idx / 30) * 200);
        //        })(i);
        //    }
        //}




        // If the left is less than zero - set it to 5
        if (parseFloat(tooltipObj.style.left) <= 5) {
            tooltipObj.style.left = '5px';
        }

        // If the tooltip goes over the right hand edge then
        // adjust the positioning
        if (parseFloat(tooltipObj.style.left) + parseFloat(tooltipObj.style.width) > window.innerWidth) {
            tooltipObj.style.left  = ''
            tooltipObj.style.right = '5px'
        }




        // If the canvas has fixed positioning then set the tooltip position to
        // fixed too
        if (RGraph.SVG.isFixed(obj.svg)) {
            var scrollTop = window.scrollY || document.documentElement.scrollTop;

            tooltipObj.style.position = 'fixed';
            tooltipObj.style.top      = opt.event.pageY - scrollTop - height - 10 + 'px';
        }



        // Cancel the mousedown event
        tooltipObj.onmousedown = function (e)
        {
            e.stopPropagation();
        };

        // Cancel the mouseup event
        tooltipObj.onmouseup = function (e)
        {
            e.stopPropagation();
        };

        // Cancel the click event
        tooltipObj.onclick  = function (e)
        {
            if (e.button == 0) {
                e.stopPropagation();
            }
        };
        
        // Add the body click handler that clears the tooltip
        document.body.addEventListener('mouseup', function (e)
        {
            RGraph.SVG.hideTooltip();
        }, false);





        //
        // Keep a reference to the tooltip in the registry
        //
        RGraph.SVG.REG.set('tooltip', tooltipObj);
        RGraph.SVG.REG.set('tooltip-lastx', parseFloat(tooltipObj.style.left));
        RGraph.SVG.REG.set('tooltip-lasty', parseFloat(tooltipObj.style.top));


        //
        // Fire the tooltip event
        //
        RGraph.SVG.fireCustomEvent(obj, 'ontooltip');
    };



// End module pattern
})(window, document);