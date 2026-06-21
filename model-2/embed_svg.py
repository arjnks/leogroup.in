import os

with open('assets/india.svg', 'r', encoding='utf-8') as f:
    svg = f.read()

with open('js/map.js', 'r', encoding='utf-8') as f:
    js = f.read()

old_block = """    // Fetch and inject the SVG map
    fetch('assets/india.svg')
        .then(response => response.text())
        .then(svgContent => {
            mapContainer.innerHTML = svgContent;
            setupMapAnimation();
        })
        .catch(err => console.error("Error loading map:", err));"""

new_block = f"""    // Inject the SVG map directly to avoid local CORS issues
    const svgContent = `{svg}`;
    mapContainer.innerHTML = svgContent;
    setupMapAnimation();"""

js = js.replace(old_block, new_block)

with open('js/map.js', 'w', encoding='utf-8') as f:
    f.write(js)
