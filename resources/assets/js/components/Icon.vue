<template>
  <svg version="1.1" :class="clazz" :role="label ? 'img' : 'presentation'" :aria-label="label" :width="width"
       :height="height" :viewBox="box" :style="style">
    <path :d="path.d" :fill="path.fill" :stroke="path.stroke" v-for="path in icon.paths"/>
  </svg>
</template>

<style>
  .svg-icon {
    display: inline-block;
    fill: currentColor;
  }

  .svg-icon.flip-horizontal {
    transform: scale(-1, 1);
  }

  .svg-icon.flip-vertical {
    transform: scale(1, -1);
  }

  .svg-icon.spin {
    animation: fa-spin 1s 0s infinite linear;
  }

  @keyframes fa-spin {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
</style>

<script>

  const convert = require('../lib/parse');

  export default {
    props: {
      name: {
        type: String,
        required: true
      },
      scale: [Number, String],
      spin: Boolean,
      flip: {
        validator: function (val) {
          return val === 'horizontal' || val === 'vertical'
        }
      },
      label: String,
      index: String,
      currentIndex: String
    },
    computed: {
      normalizedScale() {
        let scale = this.scale;
        scale = typeof scale === 'undefined' ? 1 : Number(scale);
        if (isNaN(scale) || scale <= 0) {
          console.warn(`Invalid prop: prop "scale" should be a number over 0.`, this);
          return 1
        }
        return scale
      },
      clazz() {
        return {
          'svg-icon': true,
          spin: this.spin,
          'flip-horizontal': this.flip === 'horizontal',
          'flip-vertical': this.flip === 'vertical',
          active: this.index === this.currentIndex
        }
      },
      icon() {
        let xml = require(`!xml-loader!../../img/icons/${this.name}.svg`);
        const t = xml.svg.$.viewBox.split(' ');
//        console.info(`src/svg/${this.name}.svg has been loaded`);
        return {
          width: t[2],
          height: t[3],
          paths: convert.SVGtoArray(xml.svg)
        }
      },
      box() {
        return `0 0 ${this.icon.width} ${this.icon.height}`
      },
      width() {
        return this.icon.width / 112 * this.normalizedScale
      },
      height() {
        return this.icon.height / 112 * this.normalizedScale
      },
      style() {
        if (this.normalizedScale === 1) {
          return false
        }
        return {
          fontSize: this.normalizedScale + 'em'
        }
      }
    },
    register: function () {
      console.warn("inject deprecated since v1.2.0, SVG files can be loaded directly, so just delete the inject line.")
    },
  }
</script>
