var canvas = document.getElementById('demo');

var engine = new BABYLON.Engine(canvas, true, {preserveDrawingBuffer: true, stencil: true});

var scene = createScene();

engine.runRenderLoop(function(){
    scene.render();
});
// the canvas/window resize event handler
window.addEventListener('resize', function(){
    engine.resize();
});