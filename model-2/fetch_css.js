const https = require('https');

https.get('https://www.its4logistics.com/', (res) => {
    let html = '';
    res.on('data', d => html += d);
    res.on('end', () => {
        // Find CSS files
        const cssMatches = html.match(/<link[^>]*rel="stylesheet"[^>]*href="([^"]+)"[^>]*>/g);
        if (cssMatches) {
            cssMatches.forEach(linkStr => {
                const href = linkStr.match(/href="([^"]+)"/)[1];
                let fullUrl = href.startsWith('http') ? href : `https://www.its4logistics.com${href.startsWith('/') ? '' : '/'}${href}`;
                console.log('Found CSS:', fullUrl);
                
                https.get(fullUrl, (cssRes) => {
                    let css = '';
                    cssRes.on('data', d => css += d);
                    cssRes.on('end', () => {
                        if (css.includes('MapSvg') || css.includes('MapInteractive')) {
                            console.log('\n--- CSS CONTENT FOR MAP ---');
                            // Print only rules containing MapSvg or MapInteractive
                            const rules = css.split('}');
                            rules.forEach(rule => {
                                if (rule.includes('MapSvg') || rule.includes('MapInteractive') || rule.includes('keyframes')) {
                                    console.log(rule.trim() + '}');
                                }
                            });
                        }
                    });
                });
            });
        } else {
            console.log('No CSS files found.');
        }
    });
}).on('error', e => console.error(e));
