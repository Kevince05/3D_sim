var createScene = function(){

    var scene = new BABYLON.Scene(engine);

    var camera = new BABYLON.FreeCamera('camera', new BABYLON.Vector3(600, 600, -600), scene);
    camera.setTarget(BABYLON.Vector3.Zero());

    var light = new BABYLON.HemisphericLight('light_main', new BABYLON.Vector3(0, 1, 0), scene);

    var baseplate = BABYLON.SceneLoader.ImportMesh(null, 'assets/gltf/', 'baseplate.gltf', scene);
    baseplate.rrotate(BABYLON.Axis.X, -90, BABYLON.Space.WORLD);

    return scene;
}

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