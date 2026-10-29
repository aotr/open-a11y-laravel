import { useEffect, useMemo, useState } from "react";
import { usePage } from "@inertiajs/react";
import { AccessibilityWidget, useAccessibility } from "@aotr/open-a11y/react";
import type { IAccessibilityConfig } from "@aotr/open-a11y";
import { defaultState, stateFromConfig, toConfig, type DemoState } from "../demo-config";

export default function InertiaReact() {
  const page = usePage<{ config: Partial<IAccessibilityConfig> }>();
  const { settings, engine } = useAccessibility();
  const [state, setState] = useState<DemoState>(() => stateFromConfig(page.props.config));
  const config = useMemo(() => toConfig(state), [state]);

  useEffect(() => {
    void engine?.setLanguage(state.language);
  }, [engine, state.language]);

  const update = <K extends keyof DemoState>(key: K, value: DemoState[K]) => {
    setState((current) => ({ ...current, [key]: value }));
  };

  return (
    <>
      <header className="oa-hero">
        <div className="oa-hero__main">
          <p className="oa-kicker">
            <span>03</span> Inertia + React
          </p>
          <h1>
            Server props.
            <br />
            <em>Client control.</em>
          </h1>
          <p className="oa-hero__lede">
            Laravel sends the initial widget config through Inertia. React takes over from there,
            remounting the same accessibility runtime without losing the visitor&apos;s saved state.
          </p>
        </div>

        <aside className="oa-hero__aside" aria-label="About this demo">
          <p className="oa-aside-label">The demo</p>
          <p className="oa-aside-copy">
            This page is a real Inertia component. Its controls update React state; the widget is a
            declarative React component wired to the shared open-a11y engine.
          </p>
          <dl className="oa-spec">
            <div>
              <dt>Surface</dt>
              <dd>Inertia React</dd>
            </div>
            <div>
              <dt>Runtime</dt>
              <dd>React 19</dd>
            </div>
            <div>
              <dt>State</dt>
              <dd>localStorage</dd>
            </div>
            <div>
              <dt>Package</dt>
              <dd>@aotr/open-a11y</dd>
            </div>
          </dl>
        </aside>
      </header>

      <section className="oa-workbench" aria-labelledby="react-demo-title">
        <div className="oa-explainer">
          <p className="oa-kicker">The component</p>
          <h2 id="react-demo-title">Props in, widget out.</h2>
          <p className="oa-lede">
            The Inertia page receives its initial config from Laravel, then uses the same{" "}
            <code>AccessibilityWidget</code> component as any other React application.
          </p>

          <ol className="oa-notes">
            <li>
              <strong>Server-owned defaults.</strong>
              Laravel resolves the config and passes it as an Inertia prop.
            </li>
            <li>
              <strong>Client-owned interaction.</strong>
              React state handles the live customization panel.
            </li>
            <li>
              <strong>One saved state.</strong>
              Profiles, tools, and language persist across remounts.
            </li>
          </ol>

          <div className="oa-snippet">
            <div className="oa-snippet__head">
              <span>React</span>
              <span>Inertia page</span>
            </div>
            <pre>
              <code>{`<AccessibilityWidget config={config} />`}</code>
            </pre>
          </div>

          <div className="oa-snippet oa-snippet--state">
            <div className="oa-snippet__head">
              <span>Engine state</span>
              <span>{state.position}</span>
            </div>
            <pre className="oa-code">{JSON.stringify(settings.states ?? {}, null, 2)}</pre>
          </div>
        </div>

        <aside className="oa-panel" aria-labelledby="react-customizer-title">
          <header className="oa-panel__head">
            <p className="oa-kicker">React controls</p>
            <h2 id="react-customizer-title">Shape the widget.</h2>
            <p className="oa-panel__hint">Every change remounts the widget and keeps its state.</p>
          </header>

          <div className="oa-form">
            <div className="oa-field">
              <label htmlFor="react-position">Position</label>
              <select
                id="react-position"
                value={state.position}
                onChange={(event) =>
                  update("position", event.target.value as DemoState["position"])
                }
              >
                <option value="bottom-right">Bottom right</option>
                <option value="bottom-left">Bottom left</option>
                <option value="top-right">Top right</option>
                <option value="top-left">Top left</option>
              </select>
            </div>

            <div className="oa-field">
              <label htmlFor="react-side">Panel side</label>
              <select
                id="react-side"
                value={state.side}
                onChange={(event) => update("side", event.target.value as DemoState["side"])}
              >
                <option value="right">Right</option>
                <option value="left">Left</option>
              </select>
            </div>

            <div className="oa-field">
              <span className="oa-label">
                Offset <span className="oa-label__hint">pixels from the edge</span>
              </span>
              <div className="oa-split">
                <label className="oa-mini" htmlFor="react-offset-x">
                  <span>X</span>
                  <input
                    id="react-offset-x"
                    type="number"
                    min="0"
                    max="120"
                    value={state.offsetX}
                    onChange={(event) => update("offsetX", Number(event.target.value))}
                  />
                </label>
                <label className="oa-mini" htmlFor="react-offset-y">
                  <span>Y</span>
                  <input
                    id="react-offset-y"
                    type="number"
                    min="0"
                    max="120"
                    value={state.offsetY}
                    onChange={(event) => update("offsetY", Number(event.target.value))}
                  />
                </label>
              </div>
            </div>

            <div className="oa-field">
              <label htmlFor="react-size">
                Button size <output>{state.buttonSize} px</output>
              </label>
              <input
                id="react-size"
                type="range"
                min="40"
                max="80"
                step="2"
                value={state.buttonSize}
                onChange={(event) => update("buttonSize", Number(event.target.value))}
              />
            </div>

            <div className="oa-field">
              <label htmlFor="react-size-mobile">
                Mobile button size <output>{state.buttonSizeMobile} px</output>
              </label>
              <input
                id="react-size-mobile"
                type="range"
                min="20"
                max="80"
                step="2"
                value={state.buttonSizeMobile}
                onChange={(event) => update("buttonSizeMobile", Number(event.target.value))}
              />
            </div>

            <div className="oa-field oa-field--colors">
              <label htmlFor="react-primary">Primary</label>
              <div className="oa-color">
                <input
                  id="react-primary"
                  type="color"
                  value={state.primary}
                  onChange={(event) => update("primary", event.target.value)}
                />
                <span className="oa-color__value">{state.primary}</span>
              </div>
              <label htmlFor="react-accent">Accent</label>
              <div className="oa-color">
                <input
                  id="react-accent"
                  type="color"
                  value={state.accent}
                  onChange={(event) => update("accent", event.target.value)}
                />
                <span className="oa-color__value">{state.accent}</span>
              </div>
            </div>

            <div className="oa-field">
              <label htmlFor="react-menu-title">Menu title</label>
              <input
                id="react-menu-title"
                type="text"
                value={state.menuTitle}
                onChange={(event) => update("menuTitle", event.target.value)}
              />
            </div>

            <div className="oa-field">
              <label htmlFor="react-footer-name">Footer name</label>
              <input
                id="react-footer-name"
                type="text"
                value={state.footerName}
                onChange={(event) => update("footerName", event.target.value)}
              />
            </div>

            <div className="oa-field">
              <label htmlFor="react-footer-url">Footer URL</label>
              <input
                id="react-footer-url"
                type="url"
                value={state.footerUrl}
                onChange={(event) => update("footerUrl", event.target.value)}
              />
            </div>

            <div className="oa-field">
              <label htmlFor="react-footer-text">Footer text</label>
              <input
                id="react-footer-text"
                type="text"
                value={state.footerText}
                onChange={(event) => update("footerText", event.target.value)}
              />
            </div>

            <div className="oa-field">
              <label htmlFor="react-language">Language</label>
              <select
                id="react-language"
                value={state.language}
                onChange={(event) =>
                  update("language", event.target.value as DemoState["language"])
                }
              >
                <option value="en">English</option>
                <option value="hi">हिन्दी (Hindi)</option>
              </select>
            </div>

            <div className="oa-toggles">
              <label className="oa-toggle" htmlFor="react-blur">
                <input
                  id="react-blur"
                  type="checkbox"
                  checked={state.blur}
                  onChange={(event) => update("blur", event.target.checked)}
                />
                <span className="oa-toggle__track" aria-hidden="true" />
                <span>Soften the page behind the panel</span>
              </label>
              <label className="oa-toggle" htmlFor="react-show-button">
                <input
                  id="react-show-button"
                  type="checkbox"
                  checked={state.showButton}
                  onChange={(event) => update("showButton", event.target.checked)}
                />
                <span className="oa-toggle__track" aria-hidden="true" />
                <span>Keep the floating button visible</span>
              </label>
            </div>

            <div className="oa-form__foot">
              <button
                type="button"
                className="oa-button oa-button--quiet"
                onClick={() => setState(defaultState)}
              >
                Restore defaults
              </button>
            </div>
          </div>
        </aside>
      </section>

      <AccessibilityWidget config={config} />
    </>
  );
}
