const fs = require('fs');
const map = require('@svg-maps/india').default;
const svgContent = `<svg viewBox='${map.viewBox}'>
    <defs>
        <linearGradient id="neoGold" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#bf953f" />
            <stop offset="25%" stop-color="#fcf6ba" />
            <stop offset="50%" stop-color="#b38728" />
            <stop offset="75%" stop-color="#fbf5b7" />
            <stop offset="100%" stop-color="#aa771c" />
        </linearGradient>
        <filter id="goldGlow" x="-20%" y="-20%" width="140%" height="140%">
            <feGaussianBlur stdDeviation="3" result="blur" />
            <feComposite in="SourceGraphic" in2="blur" operator="over" />
        </filter>
        <filter id="keralaGlow" x="-50%" y="-50%" width="200%" height="200%">
            <feGaussianBlur stdDeviation="5" result="blur" />
            <feComposite in="SourceGraphic" in2="blur" operator="over" />
        </filter>
    </defs>
    ${map.locations.map(l => `<path id='${l.id}' name='${l.name}' d='${l.path}'></path>`).join('')}
</svg>`;

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
        svg.style.maxHeight = '650px';
        svg.style.filter = 'drop-shadow(0 0 30px rgba(0,0,0,0.8))';

        const paths = svg.querySelectorAll('path');
        paths.forEach(p => {
            p.style.fill = '#18181b'; // darker zinc 900
            p.style.stroke = '#27272a'; // dark border
            p.style.strokeWidth = '0.5px';
            p.style.transition = 'all 0.3s ease';
        });

        const kTarget = svg.querySelector('#kl') || svg.querySelector('#kerala');
        if (kTarget) {
            // Initial Kerala state
            kTarget.style.fill = 'url(#neoGold)';
            kTarget.style.filter = 'url(#keralaGlow)';
            kTarget.style.stroke = '#fff';
            kTarget.style.strokeWidth = '1px';
            
            // Continuous pulse on Kerala
            if (window.gsap) {
                gsap.to(kTarget, {
                    opacity: 0.7,
                    duration: 2,
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
            
            // Arc logic for organic feeling
            const curveOffsetX = (startY - endY) * 0.3;
            const curveOffsetY = (endX - startX) * 0.3;

            const pathData = \`M \${startX} \${startY} Q \${midX + curveOffsetX} \${midY + curveOffsetY} \${endX} \${endY}\`;

            // Draw the underlying faint solid line
            const basePath = document.createElementNS("http://www.w3.org/2000/svg", "path");
            basePath.setAttribute("d", pathData);
            basePath.setAttribute("fill", "none");
            basePath.setAttribute("stroke", "#b38728");
            basePath.setAttribute("stroke-width", "0.5");
            basePath.style.opacity = "0.2";
            lineGroup.appendChild(basePath);

            // Draw the animated gold dashed line
            const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
            path.setAttribute("d", pathData);
            path.setAttribute("fill", "none");
            path.setAttribute("stroke", "url(#neoGold)");
            path.setAttribute("stroke-width", "2");
            path.setAttribute("stroke-dasharray", "6, 12");
            path.setAttribute("stroke-linecap", "round");
            path.setAttribute("filter", "url(#goldGlow)");
            path.style.opacity = "0.8";

            lineGroup.appendChild(path);

            // Add the glowing dot at destination
            const dot = document.createElementNS("http://www.w3.org/2000/svg", "circle");
            dot.setAttribute("cx", endX);
            dot.setAttribute("cy", endY);
            dot.setAttribute("r", "4");
            dot.setAttribute("fill", "#fcf6ba");
            dot.setAttribute("filter", "url(#goldGlow)");
            lineGroup.appendChild(dot);

            if (window.gsap) {
                // Determine duration based on distance so speed feels consistent
                const distance = Math.sqrt(Math.pow(endX - startX, 2) + Math.pow(endY - startY, 2));
                const speed = distance * 0.005; // Base speed multiplier

                // Continuous marching ants animation
                gsap.to(path, {
                    strokeDashoffset: -18, // Multiple of dash pattern (6+12)
                    duration: 1.5,
                    ease: "none",
                    repeat: -1
                });

                // Continuous pulse on the dot
                gsap.to(dot, {
                    scale: 1.8,
                    opacity: 0.6,
                    duration: 1.2 + Math.random() * 0.5,
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
console.log('Successfully wrote js/map.js with neo gold aesthetics');
