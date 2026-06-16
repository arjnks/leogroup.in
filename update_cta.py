import os

directory = 'model-2'
for filename in os.listdir(directory):
    if filename.endswith('.html'):
        filepath = os.path.join(directory, filename)
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Replace Quick Enquiry CTA
        content = content.replace('>Quick Enquiry<', '>Partner With Us<')
        
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)

print('CTA updated to Partner With Us across all pages.')
