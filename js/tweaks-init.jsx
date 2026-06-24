/* ============================================================
   Tweaks — painel de revisão (não exportar para o WordPress)
   ============================================================ */
const { useState, useEffect, useRef } = React;

const TWEAK_DEFAULTS = /*EDITMODE-BEGIN*/{
  "lime": ["#d7df23", "#c4cd12", "#e6ec74"],
  "dispFont": "Marcador",
  "headline": "",
  "cta": ""
}/*EDITMODE-END*/;

const LIME_OPTIONS = [
  ["#d7df23", "#c4cd12", "#e6ec74"], // original (logo)
  ["#e3e85f", "#d4da33", "#eef2a0"], // suave
  ["#d2e000", "#bccc00", "#e4f04d"], // vibrante
  ["#ecd320", "#d8bf0f", "#f4e878"]  // mostarda
];

const FONT_MAP = {
  "Marcador":   { family: "'Permanent Marker', cursive", disp: "marker" },
  "Manuscrito": { family: "'Caveat', cursive",           disp: "caveat" },
  "Moderno":    { family: "'Shantell Sans', cursive",    disp: "shantell" }
};

function App() {
  const [t, setTweak] = useTweaks(TWEAK_DEFAULTS);
  const originalHeadline = useRef(null);
  const originalCta = useRef(null);

  // capture defaults once
  useEffect(() => {
    const h = document.getElementById("heroHeadline");
    if (h && originalHeadline.current === null) originalHeadline.current = h.innerHTML;
    if (originalCta.current === null) {
      const c = document.querySelector(".cta-text");
      originalCta.current = c ? c.textContent : "Faça um orçamento";
    }
  }, []);

  // apply lime palette
  useEffect(() => {
    const root = document.documentElement.style;
    const p = t.lime || LIME_OPTIONS[0];
    root.setProperty("--lime", p[0]);
    root.setProperty("--lime-deep", p[1]);
    root.setProperty("--lime-soft", p[2]);
  }, [t.lime]);

  // apply display font
  useEffect(() => {
    const f = FONT_MAP[t.dispFont] || FONT_MAP["Marcador"];
    document.documentElement.style.setProperty("--font-display", f.family);
    document.body.dataset.disp = f.disp;
  }, [t.dispFont]);

  // apply headline text
  useEffect(() => {
    const h = document.getElementById("heroHeadline");
    if (!h || originalHeadline.current === null) return;
    const v = (t.headline || "").trim();
    if (v) h.textContent = v;
    else h.innerHTML = originalHeadline.current;
  }, [t.headline]);

  // apply CTA text
  useEffect(() => {
    const v = (t.cta || "").trim();
    const text = v || originalCta.current || "Faça um orçamento";
    document.querySelectorAll(".cta-text").forEach((el) => { el.textContent = text; });
  }, [t.cta]);

  return (
    <TweaksPanel title="Tweaks">
      <TweakSection label="Cor de fundo" />
      <TweakColor
        label="Amarelo-lima"
        value={t.lime}
        options={LIME_OPTIONS}
        onChange={(v) => setTweak("lime", v)}
      />
      <TweakSection label="Tipografia das headlines" />
      <TweakRadio
        label="Estilo"
        value={t.dispFont}
        options={["Marcador", "Manuscrito", "Moderno"]}
        onChange={(v) => setTweak("dispFont", v)}
      />
      <TweakSection label="Textos principais" />
      <TweakText
        label="Headline do hero"
        value={t.headline}
        placeholder="Mais de 2 milhões de contatos…"
        onChange={(v) => setTweak("headline", v)}
      />
      <TweakText
        label="Texto do botão (CTA)"
        value={t.cta}
        placeholder="Faça um orçamento"
        onChange={(v) => setTweak("cta", v)}
      />
    </TweaksPanel>
  );
}

const mount = document.createElement("div");
document.body.appendChild(mount);
ReactDOM.createRoot(mount).render(<App />);
