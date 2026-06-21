const fs = require('fs');
const map = require('@svg-maps/india').default;
const svgContent = `<svg viewBox='${map.viewBox}'>${map.locations.map(l => `<path id='${l.id}' name='${l.name}' d='${l.path}'></path>`).join('')}</svg>`;

const jsTemplate = `document.addEventListener('DOMContentLoaded', () => {
    const mapContainer = document.getElementById('map-container');
    if (!mapContainer) return;

    // Inject SVG directly to avoid local fetch CORS
    const svgString = \`${svgContent}\`;
    mapContainer.innerHTML = svgString;
    setupMapAnimation();

    function setupMapAnimation() {
        const svg = mapContainer.querySelector('svg');
        if (!svg) return;

        svg.style.width = '100%';
        svg.style.height = '100%';
        svg.style.maxHeight = '600px';
        svg.style.filter = 'drop-shadow(0 0 20px rgba(0,0,0,0.5))';

        const paths = svg.querySelectorAll('path');
        paths.forEach(p => {
            p.style.fill = '#27272a';
            p.style.stroke = '#3f3f46';
            p.style.strokeWidth = '0.5px';
            p.style.transition = 'all 0.3s ease';
        });

        const kerala = svg.querySelector('#kl'); // The ID in @svg-maps/india for Kerala is usually kl! Let's handle 'kerala' or 'kl'
        const kTarget = svg.querySelector('#kl') || svg.querySelector('#kerala');
        if (kTarget) {
            kTarget.style.fill = 'var(--primary-color)';
            kTarget.style.filter = 'drop-shadow(0 0 10px rgba(255, 255, 255, 0.5))';
            
            setTimeout(() => {
                drawEmergingLines(svg, kTarget);
            }, 100);
        }
    }

    function drawEmergingLines(svg, sourceElement) {
        // State IDs in @svg-maps/india: mh, ka, tn, dl, wb, gj
        const targets = ['mh', 'ka', 'tn', 'dl', 'wb', 'gj'];
        
        const sourceBox = sourceElement.getBBox();
        const startX = sourceBox.x + (sourceBox.width / 2);
        const startY = sourceBox.y + (sourceBox.height / 2);

        const lineGroup = document.createElementNS("http://www.w3.org/2000/svg", "g");
        svg.appendChild(lineGroup);

        targets.forEach((targetId, index) => {
            const target = svg.querySelector('#' + targetId);
            if (!target) return;

            const targetBox = target.getBBox();
            const endX = targetBox.x + (targetBox.width / 2);
            const endY = targetBox.y + (targetBox.height / 2);

            const midX = (startX + endX) / 2;
            const midY = (startY + endY) / 2;
            const curveOffsetX = (startY - endY) * 0.2;
            const curveOffsetY = (endX - startX) * 0.2;

            const pathData = \`M \${startX} \${startY} Q \${midX + curveOffsetX} \${midY + curveOffsetY} \${endX} \${endY}\`;

            const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
            path.setAttribute("d", pathData);
            path.setAttribute("fill", "none");
            path.setAttribute("stroke", "var(--primary-color)");
            path.setAttribute("stroke-width", "1.5");
            path.setAttribute("stroke-dasharray", "5, 5");
            path.style.opacity = "0";

            lineGroup.appendChild(path);

            if (window.gsap && window.ScrollTrigger) {
                const length = path.getTotalLength();
                gsap.set(path, { strokeDasharray: length, strokeDashoffset: length, opacity: 1 });
                
                gsap.to(path, {
                    strokeDashoffset: 0,
                    duration: 1.5,
                    ease: "power2.out",
                    delay: index * 0.2,
                    scrollTrigger: {
                        trigger: "#map-container",
                        start: "top 70%",
                    }
                });

                const dot = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                dot.setAttribute("cx", endX);
                dot.setAttribute("cy", endY);
                dot.setAttribute("r", "3");
                dot.setAttribute("fill", "#fff");
                dot.style.opacity = "0";
                lineGroup.appendChild(dot);

                gsap.to(dot, {
                    opacity: 1,
                    scale: 1.5,
                    duration: 0.5,
                    delay: (index * 0.2) + 1.2,
                    transformOrigin: "center center",
                    scrollTrigger: {
                        trigger: "#map-container",
                        start: "top 70%",
                    }
                });
            }
        });
    }
});
`;

fs.writeFileSync('js/map.js', jsTemplate, 'utf8');
console.log('Successfully wrote js/map.js');
