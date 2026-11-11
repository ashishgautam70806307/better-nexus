<style id="better-nexus-va-styles">
#main .va-wrap{box-sizing:border-box;width:min(1216px,calc(100% - clamp(32px,8vw,128px)));margin-inline:auto}
#main .va-section{padding:clamp(40px,6vw,84px) 0;background:#f7faf7;color:#173b38}
#main .va-lead,#main .bnc-hero:has(.va-split){background:radial-gradient(ellipse at 90% 8%,#d8eee5,transparent 72%),#f3f7ee;border-bottom:1px solid #dce8dc}
#main .bnc-hero:has(.va-split){padding:clamp(34px,5vw,65px) 0}
#main .va-split{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,.96fr);gap:clamp(28px,5vw,72px);align-items:center}
#main .va-split>*{min-width:0}
#main .va-section h1,#main .bnc-hero .va-split h1{font-size:clamp(2rem,4vw,3.85rem);line-height:1.07;letter-spacing:-.045em;color:#123a35;margin:.32em 0 .38em;overflow-wrap:break-word;text-wrap:balance}
#main .va-section h2{font-size:clamp(1.55rem,3vw,2.65rem);line-height:1.15;color:#123a35;letter-spacing:-.03em;margin:.35em 0 .68em}
#main .va-section p,#main .bnc-hero .va-split p{max-width:56ch;font-size:clamp(.98rem,1.4vw,1.12rem);line-height:1.65;color:#3b5a53;margin:0 0 15px}
#main .va-kicker{font-size:.72rem;letter-spacing:.13em;font-weight:800;color:#13685d;display:inline-block}
#main .va-crumb{display:flex;gap:.55rem;flex-wrap:wrap;line-height:1.4;font-size:.82rem;color:#456760;margin:0 0 20px}
#main .va-crumb a,#main .va-card-link{color:#106558;font-weight:700;text-underline-offset:4px}
#main .va-button{display:inline-flex;align-items:center;justify-content:center;gap:10px;background:#115b51;color:#fff;text-decoration:none;font-weight:700;font-size:.95rem;line-height:1.3;padding:13px 18px;border-radius:10px;margin:10px 0}
#main .va-button:hover{background:#073e37}
#main .va-button:focus-visible,#main .va-card:focus-visible{outline:2px solid #076d59;outline-offset:4px}
#main .va-art,#main .va-contact-art{display:block;width:100%;height:auto;aspect-ratio:5/3;object-fit:cover;border-radius:22px;border:1px solid #d5e6d8;box-shadow:0 16px 36px #245e4314}
#main .va-contact-art{max-width:500px;justify-self:end}
#main .va-cards,#main .va-steps{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}
#main .va-card{display:flex;flex-direction:column;background:#fff;color:#183d36;border:1px solid #d7e6dd;border-radius:16px;overflow:hidden;text-decoration:none}
#main .va-card:hover{border-color:#55a494;box-shadow:0 10px 26px #195d4317}
#main .va-card img{width:100%;height:auto;aspect-ratio:5/3;object-fit:cover;display:block}
#main .va-card>div{display:flex;flex-direction:column;flex:1;padding:19px 21px}
#main .va-card h3{font-size:1.22rem;line-height:1.25;margin:.55em 0 .4em;color:#173f37}
#main .va-card .va-card-link{margin-top:auto;font-size:.86rem}
#main .va-steps{padding:0;margin:0;list-style:none}
#main .va-steps li{min-width:0;background:#fff;border:1px solid #d7e6dd;border-radius:13px;padding:20px;line-height:1.5;font-weight:600}
#main .va-steps li span{display:block;color:#13685d;font-size:.76rem;margin:0 0 8px}
#main .va-callout{display:flex;justify-content:space-between;align-items:center;gap:20px;background:#e5f1e9;border-radius:15px;padding:clamp(18px,4vw,36px);margin:26px 0}
#main .va-callout h2{font-size:1.42rem;margin:0 0 7px}
#main .va-callout p{margin:0}
#main .va-home-intro .va-button{margin-right:12px}
#main .va-journal-art{width:min(100%,300px);height:auto;border-radius:14px;margin-top:12px}
#main .va-video{position:relative;isolation:isolate;background:#0c2938;overflow:hidden}
#main .va-video video{display:block;width:100%;height:auto;max-height:720px;aspect-ratio:16/9;object-fit:contain}
@media(max-width:900px){#main .va-cards{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:650px){#main .va-split,#main .va-steps,#main .va-cards{grid-template-columns:1fr}#main .va-contact-art{justify-self:start}#main .va-callout{align-items:flex-start;flex-direction:column}#main .va-video video{aspect-ratio:6/5;max-height:none}}
#main .va-catalog{background:linear-gradient(145deg,#092c38 5%,#104651 100%);color:#f3fbfb;scroll-margin-top:110px}
#main .va-catalog h2{color:#f4fbfa;font-size:clamp(1.9rem,4vw,3.6rem);margin:.35em 0 .45em}
#main .va-catalog h2 span,#main .va-catalog .va-kicker{color:#a9ded6}
#main .va-catalog>.va-wrap>p{color:#d0e5e6;margin-bottom:24px}
#main .va-service-grid{grid-template-columns:repeat(4,minmax(0,1fr));gap:18px;margin-top:22px}
#main .va-service-grid .va-card{padding:7px;border-radius:17px;border:1px solid #d8eae6;min-width:0;transition:border-color .18s,box-shadow .18s}
#main .va-service-grid .va-card:hover{border-color:#83d1c0;box-shadow:0 8px 24px #041e2966}
#main .va-service-grid .va-card:focus-visible{outline:3px solid #a9f0de;outline-offset:4px}
#main .va-service-grid .va-card img{border-radius:11px;aspect-ratio:16/9;background:#102c41}
#main .va-service-grid .va-card-body{padding:13px 10px 12px;gap:8px}
#main .va-card-heading{display:flex;align-items:flex-start;justify-content:space-between;gap:8px}
#main .va-service-grid .va-card h3{margin:0;font-size:clamp(.98rem,1.35vw,1.15rem);line-height:1.25;overflow-wrap:anywhere}
#main .va-service-grid .va-card p{margin:0;color:#435e62;font-size:.9rem;line-height:1.5;overflow-wrap:anywhere}
#main .va-card-arrow{display:grid;place-items:center;flex:none;width:24px;height:24px;border:1px solid #c0ded9;border-radius:50%;color:#11675d;font-size:.85rem;line-height:1}
#main .va-service-grid .va-card:hover .va-card-arrow{background:#0c655b;color:#fff}
@media(max-width:1050px){#main .va-service-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}
@media(max-width:820px){#main .va-service-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}}
@media(max-width:480px){#main .va-service-grid{grid-template-columns:1fr;gap:14px}}
@media(prefers-reduced-motion:reduce){#main .va-service-grid .va-card{transition:none}}
/* Keep linked sections clear of the sticky header and narrow layouts readable. */
#main :is(#bn-contact-live,#va-services){scroll-margin-top:clamp(80px,10vw,124px)}
#main .va-home-actions{display:flex;flex-wrap:wrap;align-items:center;gap:8px 20px;margin-top:12px}
#main .va-home-actions .va-button{margin:0}
#main .bnc-main .bnc-form{padding:clamp(16px,2.8vw,32px);background:#fff;border:1px solid #d7e6dd;border-radius:18px}
#main .bnc-form .bnc-field>label{font-size:.88rem;color:#254b41}
#main .bnc-form .bnc-form-intro,#main .bnc-form .bnc-help{color:#49645a}
#main .bnc-form :is(input,textarea){min-width:0}
#main .va-section :is(.bn-journal-card,.va-card) h3 a{overflow-wrap:anywhere}
#main .va-blog-lead{align-items:center}
#main .va-blog-lead .va-journal-art{justify-self:end;margin-top:0}
@media(max-width:650px){
  #main .va-blog-lead .va-journal-art{justify-self:start;width:min(100%,230px)}
  #main .bnc-form .bnc-fields{grid-template-columns:minmax(0,1fr)}
  #main .bnc-form :is(input,textarea){font-size:16px}
  #main .va-home-actions .va-card-link{display:inline-flex;align-items:center;min-height:44px}
}
#main .va-video[hidden]{display:none}
#main .va-process-steps{grid-template-columns:repeat(4,minmax(0,1fr))}
#main .va-process-steps h3{font-size:1.12rem;line-height:1.35;margin:0 0 8px;color:#173f37}
#main .va-process-steps p{margin:0;font-size:.93rem;font-weight:400}
#main .va-blog-heading{display:flex;align-items:baseline;justify-content:space-between;gap:12px 24px;flex-wrap:wrap;margin-bottom:12px}
#main .va-blog-heading>.va-card-link{margin:0}
#main .va-blog-empty{padding:16px 18px;border:1px solid #d7e6dd;border-radius:12px;background:#fff}
#main .va-faq{align-items:start}
#main .va-faq-list{display:grid;gap:10px}
#main .va-question{border:1px solid #cfe3da;background:#fff;border-radius:13px}
#main .va-question summary{display:flex;align-items:center;justify-content:space-between;gap:12px;min-height:50px;padding:12px 16px;color:#173f37;font-weight:700;cursor:pointer;list-style:none}
#main .va-question summary::-webkit-details-marker{display:none}
#main .va-question summary:focus-visible{outline:2px solid #0b7665;outline-offset:2px;border-radius:10px}
#main .va-question summary span::before{content:'+';font-size:1.2rem}
#main .va-question[open] summary span::before{content:'−'}
#main .va-question p{padding:0 16px 14px;margin:0;font-size:.94rem}
#main .va-final-cta{margin:0}
@media(max-width:900px){#main .va-process-steps{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:480px){#main .va-process-steps{grid-template-columns:1fr}}
@media(prefers-reduced-motion:reduce){#main .va-video{display:none}}

/* Frontend imagery / responsive refinement – shared across Home, Services and service details. */
#main .va-wrap, #main .va-cards, #main .va-split {min-width:0}
#main .va-service-grid .va-card{height:100%;}
#main .va-service-grid .va-card img{aspect-ratio:16/10;object-position:center;}
#main .va-service-grid .va-card-heading{min-width:0;}
#main .va-service-grid .va-card h3{hyphens:auto;}
#main .va-service-grid .va-card-body{flex:1;}
#main .va-service-grid .va-card p{margin-top:auto;}
#main .va-split .va-art{aspect-ratio:3/2;object-position:center;}
@media(max-width:650px){
  #main .va-section{padding-block:clamp(30px,8vw,48px)}
  #main .va-wrap{width:calc(100% - 32px)}
  #main .va-split{gap:22px}
  #main .va-split .va-art{aspect-ratio:16/10;border-radius:16px}
  #main .va-home-actions{align-items:stretch}
  #main .va-service-grid .va-card img{aspect-ratio:16/9}
}
@media(max-width:360px){
  #main .va-wrap{width:calc(100% - 24px)}
  #main .va-service-grid .va-card-body{padding:12px}
}
/* Phase 2: About-page content and narrow viewport legibility */
#main .va-about-pillars article{min-width:0;padding:clamp(18px,2.3vw,27px);background:#fff;border:1px solid #d7e6dd;border-radius:17px;box-shadow:0 10px 28px #1d5a3c08}
#main .va-about-pillars article>span{font-size:.73rem;letter-spacing:.08em;font-weight:800;color:#176a60}
#main .va-about-pillars h3{margin:13px 0 9px;font-size:clamp(1.12rem,1.7vw,1.35rem);line-height:1.28;color:#173f37}
#main .va-about-pillars p{font-size:.95rem;line-height:1.62;margin:0}
#main .va-about-pillars{margin-top:23px}
#main .va-about-values{background:#fff}
#main .va-about-values .va-about-pillars article{background:#f8fbf8}
@media(max-width:760px){#main .va-about-pillars{grid-template-columns:1fr 1fr}#main .va-about-pillars article:last-child{grid-column:1/-1}}
@media(max-width:650px){#main .va-about-pillars{grid-template-columns:1fr}#main .va-about-pillars article:last-child{grid-column:auto}#main .va-section .va-art{max-height:420px}#main .va-contact-art{max-width:100%;max-height:330px;object-fit:cover;object-position:center 32%}}
@media(max-width:360px){#main .va-section h1,#main .bnc-hero .va-split h1{font-size:1.95rem}}
</style>
