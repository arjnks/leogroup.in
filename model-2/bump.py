import os, re
for f in os.listdir('.'):
    if f.endswith('.html'):
        with open(f, 'r', encoding='utf-8') as file:
            content = file.read()
        content = re.sub(r'href=\"css/style\.css(\?v=\d+)?\"', 'href=\"css/style.css?v=6\"', content)
        with open(f, 'w', encoding='utf-8') as file:
            file.write(content)
