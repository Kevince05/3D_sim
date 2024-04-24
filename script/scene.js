var canvas = document.getElementById('demo');

var engine = new BABYLON.Engine(canvas, true, {preserveDrawingBuffer: true, stencil: true});

var createScene = function(){
    // Create a basic BJS Scene object
    var scene = new BABYLON.Scene(engine);
    // Create a FreeCamera, and set its position to {x: 0, y: 5, z: -10}
    var camera = new BABYLON.FreeCamera('camera1', new BABYLON.Vector3(6, 6, -6), scene);
    // Target the camera to scene origin
    camera.setTarget(BABYLON.Vector3.Zero());
    // Create a basic light, aiming 0, 1, 0 - meaning, to the sky
    var light = new BABYLON.HemisphericLight('light1', new BABYLON.Vector3(0, 1, 0), scene);
    // Create a built-in "box" shape using the CubeBuilder
    var box = BABYLON.MeshBuilder.CreateBox("box", {size: 1}, scene);
    // Move the box upward 1/2 of its height
    box.position.y = 1;
    // Create a built-in "ground" shape;
    var ground = BABYLON.MeshBuilder.CreateGround("ground1", { width: 6, height: 6, subdivisions: 2, updatable: false }, scene);
    // Return the created scene
    return scene;
}
// call the createScene function
var scene = createScene();
// run the render loop
engine.runRenderLoop(function(){
    scene.render();
});
// the canvas/window resize event handler
window.addEventListener('resize', function(){
    engine.resize();
});

window.addEventListener('keydown', function(event){
    switch(event.key){
        case 'w':
            scene.getMeshByName('box').position.y += 0.1;
            break;
        case 's':
            scene.getMeshByName('box').position.y -= 0.1;
            break;
        case 'a':
            scene.getMeshByName('box').position.x -= 0.1;
            break;
        case 'd':
            scene.getMeshByName('box').position.x += 0.1;
            break;
    }
});