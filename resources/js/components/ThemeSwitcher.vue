<template>
    <div class="flex">
        <button
            v-for="(color, theme) in themes"
            v-on:click="currentTheme = theme"
            :style="{ backgroundColor: color }"
            :class="{ 'border-accent': currentTheme == theme }"
            class="h-4 w-4 mr-2 border-2 hover:border-gray-600 rounded-full"
        ></button>
    </div>
</template>

<script>
module.exports = {
    data: function() {
        return {
            currentTheme: "theme-light",
            themes: []
        };
    },
    watch: {
        currentTheme: function() {
            document.body.className =
                document.body.className.replace(/theme-\w+/, "") +
                " " +
                this.currentTheme;

            localStorage.setItem("theme", this.currentTheme);
        }
    },
    created() {
        this.loadThemes();
        this.currentTheme = localStorage.getItem("theme")
            ? localStorage.getItem("theme")
            : this.currentTheme;
    },

    methods: {
        loadThemes: function() {
            this.themes = {
                "theme-light": "#f5f6f9",
                "theme-dark": "#222"
            };
        }
    }
};
</script>
