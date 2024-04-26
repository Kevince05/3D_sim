var createScene = function(){

    var scene = new BABYLON.Scene(engine);

    var camera = new BABYLON.FreeCamera('camera', new BABYLON.Vector3(60, 60, -60), scene);
    camera.setTarget(BABYLON.Vector3.Zero());
    camera.attachControl(canvas, true);

    var light = new BABYLON.HemisphericLight('light_main', new BABYLON.Vector3(0, 1, 0), scene);

    var baseplate = BABYLON.SceneLoader.ImportMesh(null, 'assets/', 'scene.gltf', scene);

    return scene;
}
