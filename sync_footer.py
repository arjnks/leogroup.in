import os
import re

directory = r'd:\internship work\leogroup main website\model-2'
index_path = os.path.join(directory, 'index.html')

with open(index_path, 'r', encoding='utf-8') as f:
    index_content = f.read()

# Extract the footer from index.html
footer_match = re.search(r'(<footer>.*?</footer>)', index_content, flags=re.DOTALL)
if not footer_match:
    print("Could not find footer in index.html")
    exit(1)

new_footer = footer_match.group(1)

count = 0
for filename in os.listdir(directory):
    if filename.endswith(".html") and filename not in ['index.html', 'dashboard.html']:
        filepath = os.path.join(directory, filename)
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Replace existing footer
        if '<footer>' in content:
            new_content = re.sub(r'<footer>.*?</footer>', new_footer.replace('\\', '\\\\'), content, flags=re.DOTALL)
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(new_content)
            count += 1
            print(f"Updated footer in {filename}")

print(f"Footer synchronized across {count} files.")
