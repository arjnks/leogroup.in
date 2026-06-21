const fs = require('fs');

let html = fs.readFileSync('index.html', 'utf8');

const servicesRegex = /<section class="services pin-container">[\s\S]*?(?=<section class="legacy">)/;

const newServicesHTML = `<section class="services pin-container">
    <div class="reveal-mask" style="padding: 0 5%;">
      <span class="eyebrow reveal-text">STRATEGIC PORTFOLIOS & DISTRIBUTION</span>
    </div>
    <div class="reveal-mask" style="padding: 0 5%;">
      <h2 class="section-heading reveal-text" style="margin-bottom: 0;">End-to-End Excellence,</h2>
    </div>
    <div class="reveal-mask" style="padding: 0 5%; margin-bottom: 4rem;">
      <h2 class="section-heading reveal-text" style="margin-bottom: 0;">Built for Scale.</h2>
    </div>
    
    <style>
      .pin-container { overflow: hidden; height: 100vh; display: flex; flex-direction: column; justify-content: center; }
      .scale-wrapper { display: flex; flex-direction: row; gap: 0; border-top: 1px solid var(--border-color); width: fit-content; padding-left: 5vw; padding-right: 5vw; }
      .scale-item { display: flex; flex-direction: column; align-items: flex-start; justify-content: flex-start; padding: 4rem; width: 60vw; border-right: 1px solid var(--border-color); border-bottom: none; transition: background-color 0.4s ease; height: 50vh; }
      .scale-item:hover { background-color: #fafafa; }
      .scale-number { font-family: 'DM Mono', monospace; font-size: 6rem; line-height: 0.8; font-weight: 300; color: #E4E4E7; margin-bottom: 3rem; transition: color 0.4s ease; }
      .scale-content { display: flex; flex-direction: column; gap: 1.5rem; }
      .scale-content h3 { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 300; margin: 0; color: var(--text-color); line-height: 1.1; }
      .scale-content p { font-size: 1.2rem; color: #666; margin: 0; line-height: 1.8; }
      .scale-item:hover .scale-number { color: var(--primary-color); }
      
      @media (max-width: 768px) {
          .scale-item { width: 85vw; padding: 2rem; height: auto; }
          .scale-number { font-size: 4rem; margin-bottom: 1.5rem; }
          .scale-content h3 { font-size: 2.5rem; }
      }
    </style>
    
    <div class="scale-wrapper">
      <div class="scale-item">
        <div class="scale-number">01</div>
        <div class="scale-content">
          <div style="margin-bottom: 1rem;"><img src="assets/jockey_logo.png" alt="Jockey Logo" style="height: 40px;"></div>
          <h3>Jockey<br>Distribution</h3>
          <p>Leo Group is the official Super Distributor for Jockey (Page Industries) across all of Kerala, managed directly under the Leo Group Team by specific managers dedicated solely to Jockey operations.</p>
        </div>
      </div>
      <div class="scale-item">
        <div class="scale-number">02</div>
        <div class="scale-content">
          <div style="margin-bottom: 1rem;"><img src="assets/ge_logo.png" alt="GE Logo" style="height: 40px;"></div>
          <h3>Healthcare<br>Logistics</h3>
          <p>Managed by dedicated divisions like Leo Healthcare and Leo Logistics, corporate medical equipment distribution for GE HealthCare in Kerala is primarily managed by regional medical equipment dealers.</p>
        </div>
      </div>
      <div class="scale-item">
        <div class="scale-number">03</div>
        <div class="scale-content">
          <h3>Carrying &<br>Forwarding</h3>
          <p>Operating as the central distribution nexus for India's premier pharmaceutical brands. We maintain massive, rigorously monitored cold-chain facilities capable of handling highly sensitive biologicals at state-wide scale.</p>
        </div>
      </div>
      <div class="scale-item">
        <div class="scale-number">04</div>
        <div class="scale-content">
          <h3>Wholesale<br>Network</h3>
          <p>A relentless delivery apparatus reaching thousands of retail pharmacies and general trade outlets daily. Our logistics framework ensures same-day dispatch and zero stock-outs across critical healthcare sectors.</p>
        </div>
      </div>
      <div class="scale-item">
        <div class="scale-number">05</div>
        <div class="scale-content">
          <h3>Last-Mile<br>Redistribution</h3>
          <p>Unmatched geographical penetration. We bridge the gap between major urban centers and remote rural markets, ensuring that life-saving products reach tier-2 and tier-3 towns with flawless consistency.</p>
        </div>
      </div>
      <div class="scale-item">
        <div class="scale-number">06</div>
        <div class="scale-content">
          <h3>Diversified<br>Logistics</h3>
          <p>Beyond pharmaceuticals, our logistical mastery extends across multiple high-value categories, including mobile electronics, garments, and FMCG, leveraging our 2 Lakh Sq.Ft infrastructure.</p>
        </div>
      </div>
    </div>
  </section>`;

html = html.replace(servicesRegex, newServicesHTML + '\n\n  ');

fs.writeFileSync('index.html', html, 'utf8');
console.log('Successfully reordered and styled horizontal scroll cards');
