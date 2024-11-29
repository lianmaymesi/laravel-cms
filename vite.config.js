import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            hotFile: "public/vendor/laravel-cms/laravel-cms.hot", // Most important lines
            buildDirectory: "vendor/laravel-cms",
            input: ["resources/css/app.css"],
            refresh: true,
        }),
    ],
});
