import * as THREE from 'three';

/**
 * Composable untuk background Three.js (Layer 2).
 *
 * Membuat animated mesh gradient / soft glow yang sangat halus,
 * grayscale saja, gerakan lambat hampir tak terlihat.
 * TIDAK ada objek 3D (kubus, planet, model) — murni fullscreen
 * shader plane, jadi ringan dan tidak "berebut perhatian" dengan
 * konten atau dengan tsParticles di layer atasnya.
 *
 * Dipause otomatis saat tab tidak aktif, dan semua resource
 * (geometry, material, renderer) di-dispose saat unmount.
 */
export function useThreeBackground(canvasRef) {
  let renderer, scene, camera, material, mesh, clock;
  let animationId = null;
  let resizeObserver = null;

  const vertexShader = `
    varying vec2 vUv;
    void main() {
      vUv = uv;
      gl_Position = vec4(position, 1.0);
    }
  `;

  // Noise ringkas (simplex 2D) hanya dipakai untuk membentuk gradient
  // yang lembut — bukan untuk efek visual yang ramai.
  const fragmentShader = `
    precision highp float;
    varying vec2 vUv;
    uniform float uTime;
    uniform vec2 uResolution;

    vec3 permute(vec3 x) { return mod(((x * 34.0) + 1.0) * x, 289.0); }

    float snoise(vec2 v) {
      const vec4 C = vec4(0.211324865405187, 0.366025403784439,
                          -0.577350269189626, 0.024390243902439);
      vec2 i  = floor(v + dot(v, C.yy));
      vec2 x0 = v - i + dot(i, C.xx);
      vec2 i1 = (x0.x > x0.y) ? vec2(1.0, 0.0) : vec2(0.0, 1.0);
      vec4 x12 = x0.xyxy + C.xxzz;
      x12.xy -= i1;
      i = mod(i, 289.0);
      vec3 p = permute(permute(i.y + vec3(0.0, i1.y, 1.0)) + i.x + vec3(0.0, i1.x, 1.0));
      vec3 m = max(0.5 - vec3(dot(x0, x0), dot(x12.xy, x12.xy), dot(x12.zw, x12.zw)), 0.0);
      m = m * m;
      m = m * m;
      vec3 x = 2.0 * fract(p * C.www) - 1.0;
      vec3 h = abs(x) - 0.5;
      vec3 ox = floor(x + 0.5);
      vec3 a0 = x - ox;
      m *= 1.79284291400159 - 0.85373472095314 * (a0 * a0 + h * h);
      vec3 g;
      g.x  = a0.x * x0.x + h.x * x0.y;
      g.yz = a0.yz * x12.xz + h.yz * x12.yw;
      return 130.0 * dot(m, g);
    }

    void main() {
      vec2 uv = vUv;
      uv.x *= uResolution.x / uResolution.y;

      // Kecepatan sangat rendah -> gerakan nyaris tidak terasa
      float t = uTime * 0.02;

      float n1 = snoise(uv * 1.4 + vec2(t, t * 0.6));
      float n2 = snoise(uv * 2.1 - vec2(t * 0.7, t));
      float glow = smoothstep(0.15, 0.85, (n1 + n2) * 0.5 + 0.5);

      // Grayscale only, kontras rendah supaya tidak mengganggu bacaan
      float shade = mix(0.035, 0.085, glow);
      gl_FragColor = vec4(vec3(shade), 1.0);
    }
  `;

  function init() {
    if (!canvasRef.value) return;

    scene = new THREE.Scene();
    camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
    clock = new THREE.Clock();

    renderer = new THREE.WebGLRenderer({
      canvas: canvasRef.value,
      antialias: false,
      alpha: false,
      powerPreference: 'low-power',
    });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.5));

    material = new THREE.ShaderMaterial({
      vertexShader,
      fragmentShader,
      uniforms: {
        uTime: { value: 0 },
        uResolution: { value: new THREE.Vector2(1, 1) },
      },
    });

    mesh = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), material);
    scene.add(mesh);

    handleResize();
    resizeObserver = new ResizeObserver(handleResize);
    resizeObserver.observe(canvasRef.value.parentElement);

    document.addEventListener('visibilitychange', handleVisibility);
    animate();
  }

  function handleResize() {
    if (!canvasRef.value || !renderer) return;
    const parent = canvasRef.value.parentElement;
    const width = parent.clientWidth;
    const height = parent.clientHeight;
    renderer.setSize(width, height, false);
    material.uniforms.uResolution.value.set(width, height);
  }

  function handleVisibility() {
    if (document.hidden) {
      if (animationId) cancelAnimationFrame(animationId);
      animationId = null;
    } else if (!animationId) {
      animate();
    }
  }

  function animate() {
    animationId = requestAnimationFrame(animate);
    material.uniforms.uTime.value = clock.getElapsedTime();
    renderer.render(scene, camera);
  }

  function dispose() {
    if (animationId) cancelAnimationFrame(animationId);
    document.removeEventListener('visibilitychange', handleVisibility);
    if (resizeObserver) resizeObserver.disconnect();
    if (material) material.dispose();
    if (mesh) mesh.geometry.dispose();
    if (renderer) renderer.dispose();
  }

  return { init, dispose };
}
