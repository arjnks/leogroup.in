document.addEventListener("DOMContentLoaded", () => {
    const mapContainer = document.getElementById("map-container");
    if (!mapContainer) return;

    // Fetch and inject the SVG map
    fetch('assets/india.svg')
        .then(response => response.text())
        .then(svgContent => {
            mapContainer.innerHTML = svgContent;
            setupMapAnimation();
        })
        .catch(err => console.error("Error loading map:", err));

    function setupMapAnimation() {
        const svg = mapContainer.querySelector('svg');
        if (!svg) return;

        // Styling the overall map
        svg.style.width = '100%';
        svg.style.height = '100%';
        svg.style.maxHeight = '600px';
        svg.style.filter = 'drop-shadow(0 0 20px rgba(0,0,0,0.5))';

        // Dark theme map styling
        const paths = svg.querySelectorAll('path');
        paths.forEach(p => {
            p.style.fill = '#27272a'; // Zinc 800
            p.style.stroke = '#3f3f46'; // Zinc 700
            p.style.strokeWidth = '0.5px';
            p.style.transition = 'all 0.3s ease';
        });

        // Highlight Kerala
        const kerala = svg.querySelector('#kerala');
        if (kerala) {
            kerala.style.fill = 'var(--primary-color)'; // Brand color
            kerala.style.filter = 'drop-shadow(0 0 10px rgba(255, 255, 255, 0.5))';
            
            // Wait a moment for SVG to render to get proper bounding boxes
            setTimeout(() => {
                drawEmergingLines(svg, kerala);
            }, 100);
        }
    }

    function drawEmergingLines(svg, sourceElement) {
        // Target states to draw lines to (IDs from the SVG)
        const targets = ['maharashtra', 'karnataka', 'tamilnadu', 'delhi', 'westbengal', 'gujarat'];
        
        const sourceBox = sourceElement.getBBox();
        const startX = sourceBox.x + (sourceBox.width / 2);
        const startY = sourceBox.y + (sourceBox.height / 2);

        // Group to hold the lines so they sit above the map
        const lineGroup = document.createElementNS("http://www.w3.org/2000/svg", "g");
        svg.appendChild(lineGroup);

        targets.forEach((targetId, index) => {
            const target = svg.querySelector(`#${targetId}`);
            if (!target) return;

            const targetBox = target.getBBox();
            const endX = targetBox.x + (targetBox.width / 2);
            const endY = targetBox.y + (targetBox.height / 2);

            // Calculate control point for a nice curve
            const midX = (startX + endX) / 2;
            const midY = (startY + endY) / 2;
            // Offset control point to make an arc
            const curveOffsetX = (startY - endY) * 0.2;
            const curveOffsetY = (endX - startX) * 0.2;

            const pathData = `M ${startX} ${startY} Q ${midX + curveOffsetX} ${midY + curveOffsetY} ${endX} ${endY}`;

            const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
            path.setAttribute("d", pathData);
            path.setAttribute("fill", "none");
            path.setAttribute("stroke", "var(--primary-color)");
            path.setAttribute("stroke-width", "1.5");
            path.setAttribute("stroke-dasharray", "5, 5");
            path.style.opacity = "0";

            lineGroup.appendChild(path);

            // Animate using GSAP with stagger
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

                // Add a glowing dot at the end
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
