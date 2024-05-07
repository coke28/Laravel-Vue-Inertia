import globals from "globals";
import pluginJs from "@eslint/js";
import pluginVue from "eslint-plugin-vue";

export default [
    { languageOptions: { globals: globals.browser } },
    pluginJs.configs.recommended,
    ...pluginVue.configs["flat/essential"],
    {
        rules: {
            // override/add rules settings here, such as:
            'vue/no-reserved-component-names': 'off',
            'vue/multi-word-component-names': 'off',
          
        },
    },
];
