import * as THREE from "three"
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

const renderer = new THREE.WebGLRenderer({antialias: true});
renderer.outputColorSpace = THREE.SRGBColorSpace;

renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setClearColor(0xabcdef);
renderer.setPixelRatio(window.devicePixelRatio);

document.body.appendChild(renderer.domElement);


const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 10);
camera.position.set(0, 0, 0.1);

const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.enablePan = false;
controls.minDistance = 0.5;
controls.maxDistance = 1.3;
controls.minPolarAngle = 0.5;
controls.maxPolarAngle = 1.5;
controls.autoRotate = true;
controls.target = new THREE.Vector3(0, 1, 0);

controls.update();

//adding ambient light
// const width = 4;
// const height = 2;
// const intensity = 4;
// const color = 0xffffff;
const ambientLight = new THREE.AmbientLight(0xffffff, 0.5); // color, intensity
scene.add(ambientLight);

// const rectLight = new THREE.RectAreaLight(color, intensity, width, height);
// rectLight.position.set(1, 1, 1);
// scene.add(rectLight);

// Create a PointLight in Three.js
// Create a PointLight in Three.js
const light = new THREE.PointLight(0xffffff, 10);

// Set the light's position
light.position.set(1.99029, 10, 2.27577);


// Set light color and intensity
light.color.set(0xffffff);
light.intensity = 1000 / (Math.PI * 4); // Convert 100W to Three.js intensity


// Configure shadow parameters
light.castShadow = true;
light.shadow.camera.near = 0.05;
light.shadow.bias = 1.0;

// Add the light to the scene
scene.add(light);

// Create a helper for the PointLight
const lightHelper = new THREE.PointLightHelper(light);
scene.add(lightHelper);

const hemisphereLight = new THREE.HemisphereLight(0xffffff, 0x080820, 1); // Sky color, ground color, intensity
scene.add(hemisphereLight);

let loadedMesh = "";
let mesh = ""
let cake = "Lizkaykgloss1.glb";
let cube = "cube.glb";
let book = "book_shiny.glb";
let magMatte = "letter-magazine-ng1.glb";
let magShiny = "letter-magazine-g1.glb"
let magShiny2 = "letter-magazine-g2.glb"

let scaleMesh = null; // Variable to store the scale mesh

function loadMesh(mesh) {
  // Remove the current mesh from the scene if it exists
  if (loadedMesh !== undefined && loadedMesh !== null) {
    scene.remove(loadedMesh);
    loadedMesh = null; // Reset the loadedMesh variable
  }

  const loader = new GLTFLoader().setPath('public/');
  loader.load(mesh, (gltf) => {
    console.log('loading model');
    loadedMesh = gltf.scene;
    console.log(mesh);
    console.log("yay");

    // Remove all meshes from the scene except the scale mesh
    scene.traverse((child) => {
      if (child.isMesh && child !== scaleMesh) {
        scene.remove(child);
      }
    });

    loadedMesh.traverse((child) => {
      if (child.isMesh) {
        // Apply environment map to the material
        const envMap = scene.environment; // Assuming you've already set scene.environment to your HDRI texture
        child.material.envMap = envMap;
        child.material.envMapIntensity = 1; // Adjust intensity of the environment map reflection

        child.castShadow = true;
        child.receiveShadow = true;
      }
    });

    loadedMesh.position.set(0, 1, 0);

    // Reset the camera near and far clipping planes
    camera.near = 0.1;
    camera.far = 1000;

    // Update the camera's projection matrix
    camera.updateProjectionMatrix();

    // Calculate the bounding box of the loaded mesh
    const bbox = new THREE.Box3().setFromObject(loadedMesh);

    // Calculate the center and size of the bounding box
    const bboxCenter = bbox.getCenter(new THREE.Vector3());
    const bboxSize = bbox.getSize(new THREE.Vector3());

    // Calculate the camera's near and far clipping planes based on the bounding box
    const cameraNear = Math.max(0.1, bboxSize.length() / 100);
    const cameraFar = bboxSize.length() * 10;

    // Set the camera's near and far clipping planes
    camera.near = cameraNear;
    camera.far = cameraFar;

    scene.add(loadedMesh);
    console.log('Mesh value:', loadedMesh);

    document.getElementById('progress-container').style.display = 'none';
  }, (xhr) => {
    console.log(`loading ${xhr.loaded / xhr.total * 100}%`);
  }, (error) => {
    console.error(error);
  });
}

// Function to add or remove the scale mesh
function toggleScaleMesh() {
  if (scaleMesh === null) {
    const scaleMeshLoader = new GLTFLoader().setPath('public/');
    scaleMeshLoader.load("pencil.glb", (gltf) => {
      scaleMesh = gltf.scene;

      scaleMesh.position.set(0, 1, 0);

      scene.add(scaleMesh);
      console.log('Mesh value:', scaleMesh);
    }, (xhr) => {
      console.log(`loading ${xhr.loaded / xhr.total * 100}%`);
    }, (error) => {
      console.error(error);
    });
  } else {
    scene.remove(scaleMesh);
    scaleMesh = null;
  }
}
// document.querySelectorAll('.dropdown-content a').forEach(function(option) {
//   option.addEventListener('click', function() {
//     console.log('Option clicked:', option.textContent);
    
//     // Remove the current mesh from the scene if it exists
//     if (loadedMesh !== undefined && loadedMesh !== null) {
//       scene.remove(loadedMesh);
//       loadedMesh = null; // Reset the loadedMesh variable
//     }

//     // Determine which option was clicked
//     if (option.textContent === 'Option 1') {
//       loadMesh(magShiny2);
//     } else if (option.textContent === 'Option 2') {
//       loadMesh(magMatte);
//     } else if (option.textContent === 'Option 3') {
//       loadMesh(magShiny);
//     }
//   });
// });

const updateButton = document.querySelector('.update-button');
const scaleButton = document.querySelector('.scale-button');
const tableButton = document.querySelector('.table-button');
const bookshelfButton = document.querySelector('.bookshelf-button');

updateButton.addEventListener('click', () => {
  const selectedOptions = document.querySelectorAll('input[type="radio"]:checked');
  const optionIds = Array.from(selectedOptions).map(option => option.id).join('-') + '.glb';
  loadMesh(optionIds);
});

scaleButton.addEventListener('click', () => {
  toggleScaleMesh();
  console.log('scale button clicked');
});

tableButton.addEventListener('click', () => {
  let table = "table.glb";
  loadMesh(table);
  console.log('table button clicked');
});

bookshelfButton.addEventListener('click', () => {
  let bookshelf = "bookshelf.glb";
  loadMesh(bookshelf);
  console.log('bookshelf button clicked');
});

function animate() {
  requestAnimationFrame(animate);
  controls.update();
  renderer.render(scene, camera);
}

animate();

