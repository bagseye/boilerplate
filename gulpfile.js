const { src, dest, series, parallel, watch } = require("gulp");
const sass = require("gulp-sass")(require("sass")); // ENABLE SASS
const autoprefixer = require("gulp-autoprefixer"); // PREFIXING
const cleanCSS = require("gulp-clean-css"); // MINIFY CSS
const concat = require("gulp-concat"); // CONCATENANTE FILES
const uglify = require("gulp-uglify"); // COMPRESS JS
const browserSync = require("browser-sync").create();
const del = require("del");

const paths = {
  styles: {
    src: "./assets/scss/**/*.scss",
    dest: "./dist/css/",
  },
  scripts: {
    src: "./assets/js/*.js",
    dest: "./dist/js/",
  },
  vendorStyles: {
    src: "./assets/vendor/css/*.css",
    dest: "./dist/css/",
  },
  vendorScripts: {
    src: "./assets/vendor/js/*.js",
    dest: "./dist/js/",
  },
  html: {
    src: ["./*php", "./lib/**/*"],
  },
};

function buildStyles() {
  return src(paths.styles.src)
    .pipe(sass().on("error", sass.logError))
    .pipe(
      autoprefixer({
        broswers: ["last 2 versions"],
      })
    )
    .pipe(cleanCSS())
    .pipe(concat("style.min.css"))
    .pipe(dest(paths.styles.dest))
    .pipe(browserSync.stream());
}

function buildVendorStyles() {
  return src(paths.vendorStyles.src)
    .pipe(cleanCSS())
    .pipe(concat("vendor.min.css"))
    .pipe(dest(paths.vendorStyles.dest))
    .pipe(browserSync.stream());
}

function buildScripts() {
  return src(paths.scripts.src)
    .pipe(uglify())
    .pipe(concat("main.min.js"))
    .pipe(dest(paths.scripts.dest))
    .pipe(browserSync.stream());
}

function buildVendorScripts() {
  return src(paths.vendorScripts.src)
    .pipe(uglify())
    .pipe(concat("vendor.min.js"))
    .pipe(dest(paths.vendorScripts.dest))
    .pipe(browserSync.stream());
}

function browserSyncInit(done) {
  browserSync.init({
    proxy: "http://wpacfboilerplate.local",
  });
  done();
}

function browserSyncReload(done) {
  browserSync.reload();
  done();
}

// Clean the styles out
function clean() {
  return del(["dist"]);
}

const build = series(
  clean,
  parallel(buildScripts, buildStyles, buildVendorScripts, buildVendorStyles)
);

function watchFiles() {
  watch(paths.styles.src, buildStyles);
  watch(paths.scripts.src, buildScripts);
  watch(paths.vendorStyles.src, buildVendorStyles);
  watch(paths.vendorScripts.src, buildVendorScripts);
  watch(paths.html.src, browserSyncReload);
}

const watchPro = parallel(watchFiles, browserSyncInit);

// exports.default = series(buildStyles, buildVendor, buildScripts);
// exports.default = function () {
//   watch(
//     [
//       "assets/scss/*.scss",
//       "assets/js/*.js",
//       "assets/vendor/js/*.js",
//       "assets/vendor/css/*.css",
//     ],
//     parallel(buildScripts, buildVendorScripts, buildStyles, buildVendorStyles)
//   );
// };

// exports.buildDist = parallel(
//   buildScripts,
//   buildVendorScripts,
//   buildStyles,
//   buildVendorStyles
// );

// Tasks
exports.watch = watchPro;
exports.build = build;

// Default Task
exports.default = watchPro;
