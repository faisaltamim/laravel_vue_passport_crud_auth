import Vue from "vue";

Vue.filter("CapitalizeLetter", function(content) {
    return content.charAt(0).toUpperCase() + content.slice(1); //this is capitalize code
});
