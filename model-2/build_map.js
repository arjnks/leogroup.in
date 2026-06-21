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
            <feGaussianBlur stdDeviation="4" result="blur" />
            <feComposite in="SourceGraphic" in2="blur" operator="over" />
        </filter>
        <filter id="keralaGlow" x="-50%" y="-50%" width="200%" height="200%">
            <feGaussianBlur stdDeviation="8" result="blur" />
            <feComposite in="SourceGraphic" in2="blur" operator="over" />
        </filter>
        <filter id="cometGlow" x="-50%" y="-50%" width="200%" height="200%">
            <feGaussianBlur stdDeviation="2" result="blur" />
            <feComposite in="SourceGraphic" in2="blur" operator="over" />
        </filter>
    </defs>
    ${map.locations.map(l => `<path id='${l.id}' name='${l.name}' d='${l.path}'></path>`).join('')}
</svg>`;

const jsTemplate = `document.addEventListener('DOMContentLoaded', () => {
    const mapContainer = document.getElementById('map-container');
    if (!mapContainer) return;

    // Inject SVG directly
    const svgString = \`${svgContent}\`;
    mapContainer.innerHTML = svgString;
    setupMapAnimation();

    function setupMapAnimation() {
        const svg = mapContainer.querySelector('svg');
        if (!svg) return;

        svg.style.width = '100%';
        svg.style.height = '100%';
        svg.style.maxHeight = '700px';
        svg.style.filter = 'drop-shadow(0 0 40px rgba(0,0,0,0.9))';

        const paths = svg.querySelectorAll('path');
        paths.forEach(p => {
            p.style.fill = '#111113'; // Very dark background state
            p.style.stroke = '#27272a';
            p.style.strokeWidth = '0.5px';
            p.style.transition = 'all 0.3s ease';
        });

        const kTarget = svg.querySelector('#kl') || svg.querySelector('#kerala');
        if (kTarget) {
            kTarget.style.fill = 'url(#neoGold)';
            kTarget.style.filter = 'url(#keralaGlow)';
            kTarget.style.stroke = '#fff';
            kTarget.style.strokeWidth = '1px';
            
            // Fast, energetic pulse on Kerala (heartbeat)
            if (window.gsap) {
                gsap.to(kTarget, {
                    opacity: 0.5,
                    duration: 0.8,
                    yoyo: true,
                    repeat: -1,
                    ease: "power1.inOut"
                });
            }

            setTimeout(() => {
                drawEmergingLines(svg, kTarget);
            }, 300);
        }
    }

    function drawEmergingLines(svg, sourceElement) {
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
            
            // Deeper arcs for a more dynamic "fountain" effect
            const curveOffsetX = (startY - endY) * 0.4;
            const curveOffsetY = (endX - startX) * 0.4;

            const pathData = \`M \${startX} \${startY} Q \${midX + curveOffsetX} \${midY + curveOffsetY} \${endX} \${endY}\`;

            // 1. The faint background track
            const basePath = document.createElementNS("http://www.w3.org/2000/svg", "path");
            basePath.setAttribute("d", pathData);
            basePath.setAttribute("fill", "none");
            basePath.setAttribute("stroke", "#b38728");
            basePath.setAttribute("stroke-width", "1");
            basePath.style.opacity = "0.15";
            lineGroup.appendChild(basePath);

            // 2. The high-speed "comet" energy pulse
            const cometPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
            cometPath.setAttribute("d", pathData);
            cometPath.setAttribute("fill", "none");
            cometPath.setAttribute("stroke", "#ffffff"); // Pure white core
            cometPath.setAttribute("stroke-width", "3");
            cometPath.setAttribute("stroke-linecap", "round");
            cometPath.setAttribute("filter", "url(#cometGlow)");
            lineGroup.appendChild(cometPath);

            // 3. The destination inner dot
            const innerDot = document.createElementNS("http://www.w3.org/2000/svg", "circle");
            innerDot.setAttribute("cx", endX);
            innerDot.setAttribute("cy", endY);
            innerDot.setAttribute("r", "3");
            innerDot.setAttribute("fill", "#fff");
            innerDot.setAttribute("filter", "url(#goldGlow)");
            lineGroup.appendChild(innerDot);

            // 4. The destination ripple
            const rippleDot = document.createElementNS("http://www.w3.org/2000/svg", "circle");
            rippleDot.setAttribute("cx", endX);
            rippleDot.setAttribute("cy", endY);
            rippleDot.setAttribute("r", "3");
            rippleDot.setAttribute("fill", "none");
            rippleDot.setAttribute("stroke", "#fcf6ba");
            rippleDot.setAttribute("stroke-width", "2");
            lineGroup.appendChild(rippleDot);

            if (window.gsap) {
                const length = cometPath.getTotalLength();
                
                // Configure the comet dash array to be a short segment (length 60) followed by a massive gap
                cometPath.setAttribute("stroke-dasharray", \`60, \${length + 100}\`);
                cometPath.setAttribute("stroke-dashoffset", length + 60);

                // Create a timeline for this specific path
                const tl = gsap.timeline({
                    repeat: -1, 
                    delay: Math.random() * 2 // Random start delay so they don't all fire at once
                });

                // Comet shooting animation
                // Duration depends slightly on distance so speeds are comparable
                const duration = 1 + (length / 500); 

                tl.to(cometPath, {
                    strokeDashoffset: -60, // Move completely past the end
                    duration: duration,
                    ease: "power2.inOut" // Accelerate and decelerate naturally
                });

                // When the comet hits the end, fire the ripple
                tl.fromTo(rippleDot, {
                    r: 3,
                    opacity: 1,
                    strokeWidth: 3
                }, {
                    r: 25, // Expand massively
                    opacity: 0, // Fade out completely
                    strokeWidth: 0,
                    duration: 0.8,
                    ease: "power2.out"
                }, \`-=\${0.2}\`); // Fire slightly before the comet completely disappears

                // Small resting period before the next pulse fires
                tl.to({}, { duration: 0.5 + Math.random() }); 

                // Keep the inner dot pulsing independently for ambient life
                gsap.to(innerDot, {
                    scale: 1.5,
                    opacity: 0.6,
                    duration: 0.8 + Math.random() * 0.4,
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
console.log('Successfully wrote js/map.js with high-energy comet animations');
