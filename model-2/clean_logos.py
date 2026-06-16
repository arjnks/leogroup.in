import os
from PIL import Image

def clean_image(filepath):
    try:
        img = Image.open(filepath).convert("RGBA")
        datas = img.getdata()

        newData = []
        for item in datas:
            # item is (R, G, B, A)
            r, g, b, a = item
            
            # Condition for near white or light gray (checkerboard)
            if a > 0:
                is_near_white = (r > 240 and g > 240 and b > 240)
                is_light_gray = (abs(r - g) < 15 and abs(g - b) < 15 and r > 190)
                
                if is_near_white or is_light_gray:
                    newData.append((255, 255, 255, 0)) # Make transparent
                else:
                    newData.append(item)
            else:
                newData.append(item)

        img.putdata(newData)
        
        # Save as PNG (to support transparency)
        # If original was JPG, save as PNG and we will rename it in HTML
        new_filepath = filepath
        if filepath.lower().endswith(('.jpg', '.jpeg')):
            new_filepath = filepath.rsplit('.', 1)[0] + '.png'
            
        img.save(new_filepath, "PNG")
        print(f"Cleaned {filepath} -> {new_filepath}")
        
    except Exception as e:
        print(f"Failed to process {filepath}: {e}")

# Directories to process
directories = [
    r"d:\internship work\leogroup main website\model-2\assets",
    r"d:\internship work\leogroup main website\model-2\assets\logospharma\attachments"
]

for directory in directories:
    for filename in os.listdir(directory):
        if filename.lower().endswith(('.png', '.jpg', '.jpeg')):
            filepath = os.path.join(directory, filename)
            clean_image(filepath)
