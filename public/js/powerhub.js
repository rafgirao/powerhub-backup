var $chart = $('#chart-lead-container');

funnel = new RGraph.SVG.Funnel({
    id: 'chart-lead-container',
    data: $chart.data('chart-values').split('|'),

    options: {
        // title: 'A "key stages of plan CD1" funnel',
        // titleSubtitle: 'Each stage is depicted by a separate color',
        marginTop: 75,
        linewidth: 0,
        colors: ['#1C2A4B','#E96D4C','#8B98A8'],
        backgroundBars: false,
        backgroundBarsColors: ['Gradient(#1C2A4B:white)', 'Gradient(#6271DD:white)', 'Gradient(#8B98A8:white)', 'Gradient(#E96D4C:white)','Gradient(#1C2A4B:white)', 'Gradient(#6271DD:white)', 'Gradient(#8B98A8:white)', 'Gradient(#E96D4C:white)'],
        labels: $chart.data('chart-labels').split('|'),

        labelsItalic: false,
        labelsBold: false,
        labelsColor: 'black',
        labelsHalign: 'center',
        labelsBackground: false,

        // This can also be set to 'edge/section' and controls the vertical positioning
        // of the labels
        labelsPosition: 'section',

        // Tooltips for the chart which are using the new formatted tooltips feature
        // tooltips: 'asdfasf',

        // These are CSS styles for the tooltips that are displayed.
        // The names are exactly the same as CSS properties (the JavaScript
        // versions of the names)
        // tooltipsCss: {
        //     fontSize: '26pt'
        // },

        // key: ['Introduction','Site visit','Finalisation']
    }
}).draw().responsive([
    {maxWidth: null,  width:'100%', height:360, options: {labelsSize: 12, marginRight: 25, marginLeft: 10}}
]);
