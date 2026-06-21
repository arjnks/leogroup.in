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

        const kTarget = svg.querySelector('#kl') || svg.querySelector('#kerala');
        if (kTarget) {
            kTarget.style.fill = 'var(--primary-color)';
            kTarget.style.filter = 'drop-shadow(0 0 10px rgba(255, 255, 255, 0.5))';
            
            // Continuous pulse on Kerala
            if (window.gsap) {
                gsap.to(kTarget, {
                    fill: "#ff7b00", // slightly brighter orange
                    filter: "drop-shadow(0 0 15px rgba(255, 123, 0, 0.8))",
                    duration: 1.5,
                    yoyo: true,
                    repeat: -1,
                    ease: "sine.inOut"
                });
            }

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
            path.setAttribute("stroke-dasharray", "4, 6"); // Dashed line for marching ants
            path.style.opacity = "0.7";

            lineGroup.appendChild(path);

            // Add the glowing dot
            const dot = document.createElementNS("http://www.w3.org/2000/svg", "circle");
            dot.setAttribute("cx", endX);
            dot.setAttribute("cy", endY);
            dot.setAttribute("r", "3");
            dot.setAttribute("fill", "#fff");
            dot.style.filter = "drop-shadow(0 0 5px rgba(255,255,255,0.8))";
            lineGroup.appendChild(dot);

            if (window.gsap) {
                // Continuous marching ants animation
                gsap.to(path, {
                    strokeDashoffset: -20, // Moves the dashes along the path continuously
                    duration: 1,
                    ease: "none",
                    repeat: -1
                });

                // Continuous pulse on the dot
                gsap.to(dot, {
                    scale: 1.5,
                    opacity: 0.6,
                    duration: 1 + Math.random() * 0.5, // slightly offset the pulses
                    yoyo: true,
                    repeat: -1,
                    transformOrigin: "center",
                    ease: "sine.inOut"
                });
            }
        });
    }
});
`;

fs.writeFileSync('js/map.js', jsTemplate, 'utf8');
console.log('Successfully wrote js/map.js with live animations');
