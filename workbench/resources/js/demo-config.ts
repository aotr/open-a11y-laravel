import { mergeConfig, type IAccessibilityConfig } from "@aotr/open-a11y";

export interface DemoState {
  position: "bottom-right" | "bottom-left" | "top-right" | "top-left";
  side: "right" | "left";
  offsetX: number;
  offsetY: number;
  blur: boolean;
  buttonSize: number;
  buttonSizeMobile: number;
  showButton: boolean;
  primary: string;
  accent: string;
  footerName: string;
  footerUrl: string;
  footerText: string;
  menuTitle: string;
  language: "en" | "hi";
}

export const defaultState: DemoState = {
  position: "bottom-right",
  side: "right",
  offsetX: 20,
  offsetY: 20,
  blur: true,
  buttonSize: 56,
  buttonSizeMobile: 44,
  showButton: true,
  primary: "#0f6b4f",
  accent: "#d4a13a",
  footerName: "open-a11y demo",
  footerUrl: "https://github.com/aotr/open-a11y",
  footerText: "Accessibility tools by open-a11y",
  menuTitle: "Accessibility options",
  language: "en",
};

export function stateFromConfig(config: Partial<IAccessibilityConfig>): DemoState {
  return {
    ...defaultState,
    position: config.position ?? defaultState.position,
    side: config.side ?? defaultState.side,
    offsetX: config.offset?.[0] ?? defaultState.offsetX,
    offsetY: config.offset?.[1] ?? defaultState.offsetY,
    blur: config.blur ?? defaultState.blur,
    buttonSize: config.buttonSize ?? defaultState.buttonSize,
    buttonSizeMobile: config.buttonSizeMobile ?? defaultState.buttonSizeMobile,
    showButton: config.showButton ?? defaultState.showButton,
    primary: config.brand?.primary ?? defaultState.primary,
    accent: config.brand?.accent ?? defaultState.accent,
    footerName: config.brand?.name ?? defaultState.footerName,
    footerUrl: config.brand?.url ?? defaultState.footerUrl,
    footerText: config.brand?.footerText ?? defaultState.footerText,
    menuTitle: config.labels?.["widget.menuTitle"] ?? defaultState.menuTitle,
    language: (config.lang as DemoState["language"]) ?? defaultState.language,
  };
}

export function toConfig(state: DemoState): IAccessibilityConfig {
  return mergeConfig({
    position: state.position,
    side: state.side,
    offset: [state.offsetX, state.offsetY],
    blur: state.blur,
    buttonSize: state.buttonSize,
    buttonSizeMobile: state.buttonSizeMobile,
    showButton: state.showButton,
    lang: state.language,
    brand: {
      name: state.footerName,
      url: state.footerUrl,
      footerText: state.footerText,
      primary: state.primary,
      primaryDark: state.primary,
      accent: state.accent,
    },
    labels: {
      "widget.menuTitle": state.menuTitle,
    },
  });
}
