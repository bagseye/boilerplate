const { src, dest, series, parallel, watch } = require("gulp");
const sass = require("gulp-sass")(require("sass")); // ENABLE SASS
const autoprefixer = require("gulp-autoprefixer"); // PREFIXING
const cleanCSS = require("gulp-clean-css"); // MINIFY CSS
const concat = require("gulp-concat"); // CONCATENANTE FILES
const uglify = require("gulp-uglify"); // COMPRESS JS

function buildStyles() {
  return src("assets/scss/*.scss")
    .pipe(sass().on("error", sass.logError))
    .pipe(
      autoprefixer({
        broswers: ["last 2 versions"],
      })
    )
    .pipe(cleanCSS())
    .pipe(concat("style.min.css"))
    .pipe(dest("./dist/css"));
}

function buildVendorStyles() {
  return src("assets/vendor/css/*.css")
    .pipe(cleanCSS())
    .pipe(concat("vendor.min.css"))
    .pipe(dest("dist/css"));
}

function buildScripts() {
  return src("assets/js/*.js")
    .pipe(uglify())
    .pipe(concat("main.min.js"))
    .pipe(dest("dist/js"));
}

function buildVendorScripts() {
  return src("assets/vendor/js/*.js")
    .pipe(uglify())
    .pipe(concat("vendor.min.js"))
    .pipe(dest("dist/js"));
}

// exports.default = series(buildStyles, buildVendor, buildScripts);
exports.default = function () {
  watch(
    [
      "assets/scss/*.scss",
      "assets/js/*.js",
      "assets/vendor/js/*.js",
      "assets/vendor/css/*.css",
    ],
    parallel(buildScripts, buildVendorScripts, buildStyles, buildVendorStyles)
  );
};

exports.buildDist = parallel(
  buildScripts,
  buildVendorScripts,
  buildStyles,
  buildVendorStyles
);
