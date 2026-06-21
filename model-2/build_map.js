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
            <feGaussianBlur stdDeviation="5" result="blur" />
            <feComposite in="SourceGraphic" in2="blur" operator="over" />
        </filter>
        <filter id="keralaGlow" x="-50%" y="-50%" width="200%" height="200%">
            <feGaussianBlur stdDeviation="8" result="blur" />
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
        svg.style.filter = 'drop-shadow(0 0 30px rgba(0,0,0,0.8))';

        const paths = svg.querySelectorAll('path');
        paths.forEach(p => {
            p.style.fill = '#111113'; 
            p.style.stroke = '#27272a';
            p.style.strokeWidth = '0.5px';
            p.style.transition = 'all 0.5s ease';
        });

        const kTarget = svg.querySelector('#kl') || svg.querySelector('#kerala');
        if (kTarget) {
            kTarget.style.fill = 'url(#neoGold)';
            kTarget.style.filter = 'url(#keralaGlow)';
            kTarget.style.stroke = '#fff';
            kTarget.style.strokeWidth = '0.5px';
            
            // Refined, slow luxurious pulse (breathing effect)
            if (window.gsap) {
                gsap.to(kTarget, {
                    opacity: 0.7,
                    duration: 3,
                    yoyo: true,
                    repeat: -1,
                    ease: "sine.inOut"
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
            
            // Elegant, sweeping arcs
            const curveOffsetX = (startY - endY) * 0.3;
            const curveOffsetY = (endX - startX) * 0.3;

            const pathData = \`M \${startX} \${startY} Q \${midX + curveOffsetX} \${midY + curveOffsetY} \${endX} \${endY}\`;

            // Faint baseline path
            const basePath = document.createElementNS("http://www.w3.org/2000/svg", "path");
            basePath.setAttribute("d", pathData);
            basePath.setAttribute("fill", "none");
            basePath.setAttribute("stroke", "#b38728");
            basePath.setAttribute("stroke-width", "0.5");
            basePath.style.opacity = "0.2";
            lineGroup.appendChild(basePath);

            // The animated light streak
            const streakPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
            streakPath.setAttribute("d", pathData);
            streakPath.setAttribute("fill", "none");
            streakPath.setAttribute("stroke", "url(#neoGold)"); 
            streakPath.setAttribute("stroke-width", "2");
            streakPath.setAttribute("stroke-linecap", "round");
            streakPath.setAttribute("filter", "url(#goldGlow)");
            lineGroup.appendChild(streakPath);

            // Destination dot
            const destDot = document.createElementNS("http://www.w3.org/2000/svg", "circle");
            destDot.setAttribute("cx", endX);
            destDot.setAttribute("cy", endY);
            destDot.setAttribute("r", "4");
            destDot.setAttribute("fill", "#fcf6ba");
            destDot.setAttribute("filter", "url(#goldGlow)");
            destDot.style.opacity = "0.4";
            lineGroup.appendChild(destDot);

            if (window.gsap) {
                const length = streakPath.getTotalLength();
                const streakLength = length * 0.4; // The streak covers 40% of the path at a time
                
                streakPath.setAttribute("stroke-dasharray", \`\${streakLength}, \${length * 2}\`);
                streakPath.setAttribute("stroke-dashoffset", length + streakLength);

                // Elegant master timeline for each path
                const tl = gsap.timeline({
                    repeat: -1,
                    delay: index * 0.5 // perfectly orchestrated stagger
                });

                // Streak flowing gracefully
                tl.to(streakPath, {
                    strokeDashoffset: -streakLength,
                    duration: 3, // Slow and deliberate
                    ease: "sine.inOut"
                });

                // The destination dot blooms softly when the streak hits
                // The streak hits roughly at 60% of the duration
                tl.to(destDot, {
                    r: 6,
                    opacity: 1,
                    duration: 0.6,
                    ease: "power2.out"
                }, 1.8);

                // Dot fades back down
                tl.to(destDot, {
                    r: 4,
                    opacity: 0.4,
                    duration: 1.2,
                    ease: "power2.inOut"
                }, ">");

                // Rest period before next cycle
                tl.to({}, { duration: 1 });
            }
        });
    }
});
`;

fs.writeFileSync('js/map.js', jsTemplate, 'utf8');
console.log('Successfully wrote js/map.js with refined luxurious animations');
