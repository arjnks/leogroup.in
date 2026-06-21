const fs = require('fs');
const path = require('path');

const dir = 'd:/internship work/leogroup main website/model-2';

fs.readdirSync(dir).forEach(file => {
    if (file.endsWith('.html')) {
        const filePath = path.join(dir, file);
        let content = fs.readFileSync(filePath, 'utf8');
        if (content.includes('1980')) {
            content = content.replace(/1980/g, '1974');
            fs.writeFileSync(filePath, content, 'utf8');
            console.log(`Updated ${file}`);
        }
    }
});
