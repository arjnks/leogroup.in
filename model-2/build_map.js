const fs = require('fs');
const map = require('@svg-maps/india').default;
const svgContent = `<svg viewBox='${map.viewBox}'>
    <defs>
        <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
            <feGaussianBlur stdDeviation="3" result="blur" />
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
        svg.style.filter = 'drop-shadow(0 20px 40px rgba(0,0,0,0.15))'; 

        // Base map style
        const paths = svg.querySelectorAll('path');
        paths.forEach(p => {
            p.style.fill = '#1a1a1a'; // Dark solid background
            p.style.fillOpacity = '1'; // Solid, no transparency leaking the white page
            p.style.stroke = '#333333'; 
            p.style.strokeWidth = '1px';
            p.style.strokeLinecap = 'round';
            p.style.transition = 'fill 0.5s ease, fill-opacity 0.5s ease';
        });

        const kTarget = svg.querySelector('#kl') || svg.querySelector('#kerala');
        if (kTarget) {
            // Source region lit up (Solid yellow)
            kTarget.style.fill = '#f5d40c';
            kTarget.style.fillOpacity = '1';
            kTarget.style.stroke = '#f5d40c';
            
            setTimeout(() => {
                drawEmergingLines(svg, kTarget);
            }, 500);
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

            // Target region lit up (Calculated solid color: 20% yellow over 80% #1a1a1a)
            // This prevents the white page background from showing through
            target.style.fill = '#463f17';
            target.style.fillOpacity = '1';
            target.style.stroke = '#5c521a';

            const targetBox = target.getBBox();
            const endX = targetBox.x + (targetBox.width / 2);
            const endY = targetBox.y + (targetBox.height / 2);

            const midX = (startX + endX) / 2;
            const midY = (startY + endY) / 2;
            
            const curveOffsetX = (startY - endY) * 0.2;
            const curveOffsetY = (endX - startX) * 0.2;

            const pathData = \`M \${startX} \${startY} Q \${midX + curveOffsetX} \${midY + curveOffsetY} \${endX} \${endY}\`;

            const streakPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
            streakPath.setAttribute("d", pathData);
            streakPath.setAttribute("fill", "none");
            streakPath.setAttribute("stroke", "#ffffff"); 
            streakPath.setAttribute("stroke-width", "2.5");
            streakPath.setAttribute("stroke-linecap", "round");
            streakPath.setAttribute("filter", "url(#glow)");
            lineGroup.appendChild(streakPath);

            const destDot = document.createElementNS("http://www.w3.org/2000/svg", "circle");
            destDot.setAttribute("cx", endX);
            destDot.setAttribute("cy", endY);
            destDot.setAttribute("r", "5");
            destDot.setAttribute("fill", "#ffffff");
            destDot.setAttribute("filter", "url(#glow)");
            destDot.style.opacity = "0";
            lineGroup.appendChild(destDot);

            if (window.gsap) {
                const length = streakPath.getTotalLength();
                
                streakPath.setAttribute("stroke-dasharray", length);
                streakPath.setAttribute("stroke-dashoffset", length); 

                const tl = gsap.timeline({
                    repeat: -1,
                    delay: index * 0.3 
                });

                tl.fromTo(streakPath, 
                    { strokeDashoffset: length, opacity: 1 }, 
                    { strokeDashoffset: 0, duration: 1.5, ease: "power1.inOut" }
                );

                tl.fromTo(destDot, 
                    { opacity: 0, scale: 0.5, transformOrigin: "center" }, 
                    { opacity: 1, scale: 1.5, duration: 0.2, ease: "power2.out" }, 
                    "-=0.2"
                );

                tl.to([streakPath, destDot], { opacity: 0, duration: 0.5, ease: "power1.in" }, "+=0.1");

                tl.to({}, { duration: 0.5 });
            }
        });
    }
});
`;

fs.writeFileSync('js/map.js', jsTemplate, 'utf8');
console.log('Successfully updated map.js to use solid fill colors');
