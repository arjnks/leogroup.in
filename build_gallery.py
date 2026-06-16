import os
import shutil
import re

src_dir = r'd:\internship work\leogroup main website\piback\gallery'
dest_dir = r'd:\internship work\leogroup main website\model-2\assets\albums'
html_file = r'd:\internship work\leogroup main website\model-2\gallery.html'

if os.path.exists(dest_dir):
    shutil.rmtree(dest_dir)
os.makedirs(dest_dir)

cat_map = {
    '1': 'Tour',
    '7': 'Our Warehouse',
    '8': 'Team & Events',
    '2': 'Honours',
    '6': 'Logistucs',
    '9': 'Golden Jubilee'
}

albums_html = '<div class="albums-grid" id="albums-view">\n'
galleries_html = ""

for cat_id, cat_name in cat_map.items():
    cat_dir = os.path.join(dest_dir, f'cat_{cat_id}')
    os.makedirs(cat_dir)
    
    files = [f for f in os.listdir(src_dir) if f.startswith(cat_id) and (f.lower().endswith('.jpg') or f.lower().endswith('.png'))]
    if not files:
        continue
        
    copied_files = []
    for f in files:
        src = os.path.join(src_dir, f)
        dst = os.path.join(cat_dir, f)
        # Skip copying 7MB files if any, to keep it fast, but let's just copy them
        shutil.copy2(src, dst)
        copied_files.append(f'assets/albums/cat_{cat_id}/{f}')
        
    thumbnails = copied_files[:3]
    while len(thumbnails) < 3:
        thumbnails.append(thumbnails[0])
        
    album_id = f"album-{cat_id}"
    
    albums_html += f'''
    <div class="album-card fade-up" onclick="showGallery('{album_id}')">
      <div class="album-stack">
        <img src="{thumbnails[0]}" class="skw-1">
        <img src="{thumbnails[1]}" class="skw-3">
        <img src="{thumbnails[2]}" class="skw-2">
      </div>
      <div class="album-title">
        <h4>{cat_name}</h4>
      </div>
    </div>
    '''
    
    galleries_html += f'''
    <div class="gallery-view" id="{album_id}" style="display: none;">
      <div class="gallery-nav fade-up">
        <button class="btn btn-outline" onclick="showAlbums()" style="padding: 0.5rem 1.5rem; font-size: 0.9rem;">&larr; Back to Albums</button>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 300; margin: 0; color: var(--primary-color);">{cat_name}</h2>
      </div>
      <div class="gallery-grid">
    '''
    for i, img in enumerate(copied_files):
        # Adding staggered classes just for grid variety
        span_class = ""
        if i == 0 or i == 5 or i == 10:
            span_class = ' style="grid-column: span 2; grid-row: span 2;"'
        galleries_html += f'''<div class="gallery-item fade-up"{span_class}><div class="gallery-image" style="background-image: url('{img}');"></div></div>\n'''
    galleries_html += '''
      </div>
    </div>
    '''

albums_html += '</div>\n'

# Now we need to update the gallery.html file.
with open(html_file, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace existing gallery-grid with our new HTML
new_body = albums_html + galleries_html
content = re.sub(r'<section class="gallery-grid">.*?</section>', f'<section class="gallery-wrapper" style="padding: 5rem 5%;">\n{new_body}\n</section>', content, flags=re.DOTALL)

# Add CSS for albums and stacks
css_append = """
    /* Albums Grid */
    .albums-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 4rem 2rem; }
    .album-card { cursor: pointer; text-align: center; }
    .album-card:hover .skw-1 { transform: rotate(-8deg) scale(1.05); }
    .album-card:hover .skw-3 { transform: rotate(8deg) scale(1.05); }
    .album-card:hover .skw-2 { transform: scale(1.1); filter: grayscale(0%); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
    .album-stack { position: relative; height: 250px; margin-bottom: 2rem; display: flex; justify-content: center; align-items: center; }
    .album-stack img { position: absolute; max-width: 80%; max-height: 100%; border: 4px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.3); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); object-fit: cover; }
    .skw-1 { transform: rotate(-5deg); z-index: 1; filter: grayscale(80%); }
    .skw-3 { transform: rotate(5deg); z-index: 2; filter: grayscale(80%); }
    .skw-2 { transform: rotate(0deg); z-index: 3; filter: grayscale(30%); }
    .album-title h4 { font-family: 'DM Mono', monospace; font-size: 1.2rem; color: var(--primary-color); text-transform: uppercase; letter-spacing: 2px; }
    
    .gallery-nav { display: flex; align-items: center; justify-content: space-between; margin-bottom: 3rem; }
    
    @media (max-width: 768px) {
        .albums-grid { grid-template-columns: 1fr; gap: 3rem; }
        .gallery-nav { flex-direction: column-reverse; align-items: flex-start; gap: 1.5rem; }
    }
"""

content = content.replace('</style>', f'{css_append}\n  </style>')

# Add JS toggle logic
js_append = """
    function showGallery(id) {
        document.getElementById('albums-view').style.display = 'none';
        document.getElementById(id).style.display = 'block';
        window.scrollTo(0, 0);
        // Refresh scrolltrigger since DOM changed
        if(typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh();
    }
    function showAlbums() {
        document.querySelectorAll('.gallery-view').forEach(el => el.style.display = 'none');
        document.getElementById('albums-view').style.display = 'grid';
        window.scrollTo(0, 0);
        if(typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh();
    }
"""
content = content.replace('</script>\n</body>', f'{js_append}\n  </script>\n</body>')

with open(html_file, 'w', encoding='utf-8') as f:
    f.write(content)
print('Gallery updated with Albums view.')
