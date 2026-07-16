import { tsParticles } from '@tsparticles/engine';
import { loadSlim } from '@tsparticles/slim';

let engineLoaded = false;

export function useParticles() {
  async function init(containerId) {
    if (!engineLoaded) {
      await loadSlim(tsParticles);
      engineLoaded = true;
    }

    const isMobile = window.innerWidth < 768;

    await tsParticles.load({
      id: containerId,
      options: {
        fullScreen: { enable: false },
        background: { color: { value: 'transparent' } },
        fpsLimit: 60,
        pauseOnBlur: true,
        pauseOnOutsideViewport: true,
        detectRetina: true,
        particles: {
          number: {
            value: isMobile ? 55 : 140,
            density: { enable: true, area: 700 },
          },
          color: { value: '#ffffff' },
          opacity: {
            value: 0.25,
            animation: { enable: false },
          },
          size: { value: { min: 1, max: 2 } },
          links: {
            enable: true,
            distance: 130,
            color: '#ffffff',
            opacity: 0.08,
            width: 1,
          },
          move: {
            enable: true,
            speed: 0.35,
            direction: 'none',
            random: true,
            straight: false,
            outModes: { default: 'out' },
            attract: {
              enable: !isMobile,
              rotate: { x: 1200, y: 1200 },
            },
          },
          twinkle: {
            particles: {
              enable: true,
              color: '#ffffff',
              frequency: 0.03,
              opacity: 0.6,
            },
          },
        },
        interactivity: {
          detectsOn: 'window',
          events: {
            onHover: {
              enable: true,
              mode: isMobile ? 'grab' : ['attract', 'grab'],
            },
            onClick: {
              enable: !isMobile,
              mode: 'bubble',
            },
            resize: { enable: true },
          },
          modes: {
            grab: {
              distance: 160,
              links: { opacity: 0.25 },
            },
            attract: {
              distance: 180,
              duration: 0.4,
              factor: 3,
              speed: 0.6,
              maxSpeed: 20,
              easing: 'ease-out-quad',
            },
            bubble: {
              distance: 200,
              size: 3.5,
              duration: 0.5,
              opacity: 0.6,
              mix: false,
            },
          },
        },
      },
    });
  }

  function dispose(containerId) {
    const container = tsParticles.item(containerId);
    if (container) container.destroy();
  }

  return { init, dispose };
}
