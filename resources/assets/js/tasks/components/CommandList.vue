<template>
    <click-to-close :do="close">
        <div class="search-select">
            <input type="text" name="command" ref="input" readonly @click="open" class="uk-input" v-model="selected" placeholder="Select a command"/>
            <div ref="dropdown" v-show="isOpen" class="uk-card uk-card-default uk-padding-small uk-box-shadow-large">
                <div class="uk-search uk-search-default uk-width-1-1">
                    <span class="uk-search-icon-flip" uk-search-icon></span>
                    <label>
                        <input class="uk-input"
                               type="search"
                               v-model="search"
                               ref="search"
                               @keydown.esc="close"
                               @keydown.down="highlightNext"
                               @keydown.up="highlightPrev"
                               @keydown.enter.prevent="selectHighlighted"
                               @keydown.tab.prevent>
                    </label>
                </div>

                <ul ref="options" v-show="filteredOptions.length > 0" class="uk-list uk-list-striped uk-height-max-medium uk-position-relative uk-overflow-auto">
                    <li class="search-select-option" :class="{ 'uk-text-bold': index === highlightedIndex }"
                        v-for="(option, index) in filteredOptions"
                        :key="option.name"
                        @click="select(option)">
                        {{ option.name }}
                        <em class="uk-padding-small uk-padding-remove-top uk-padding-remove-bottom uk-padding-remove-right">
                            {{option.description}}
                        </em> 
                    </li>
                </ul>
                <div v-show="filteredOptions.length <= 0" class="uk-padding-small">
                    No results found for "{{ search }}"
                </div>
            </div>
        </div>        
    </click-to-close>
</template>

<style scoped>
    .search-select-option {
        background: transparent;
    }
    .search-select-option:hover {
        cursor: pointer;
    }
</style>

<script>
  import ClickToClose from "../../components/ClickToClose";
  export default {
    name: 'CommandList',
    components: {ClickToClose},
    props: ['command', 'commands'],
    data() {
      return {
        selected: decodeURI(this.command),
        options: Object.values(this.commands),
        isOpen: false,
        search: '',
        highlightedIndex: 0
      };
    },
    computed: {
      filteredOptions() {
        return this.options.filter(option => option.name.toLowerCase().includes(this.search.toLowerCase()));
      }
    },
    methods: {
      open() {
        if (this.isOpen) {
          return;
        }

        this.isOpen = true;
        this.highlightedIndex = this.options.findIndex(option => option.name === this.selected);
        this.$nextTick(() => {
          this.$refs.search.focus();
          this.scrollToHighlighted();
        });
      },
      close() {
        if (!this.isOpen) {
          return;
        }

        this.isOpen = false;
        this.$refs.input.focus();
      },
      select(option) {
        this.selected = option.name;
        this.search = '';
        this.highlightedIndex = 0;
        this.close();
      },
      selectHighlighted() {
        this.select(this.filteredOptions[this.highlightedIndex]);
      },
      scrollToHighlighted() {
        this.$refs.options.children[this.highlightedIndex].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
      },
      highlight(index) {
        this.highlightedIndex = index;

        if (this.highlightedIndex < 0) {
          this.highlightedIndex = this.filteredOptions.length - 1;
        }

        if (this.highlightedIndex > this.filteredOptions.length - 1) {
          this.highlightedIndex = 0;
        }

        this.scrollToHighlighted();
      },
      highlightNext() {
        this.highlight(this.highlightedIndex + 1);
      },
      highlightPrev() {
        this.highlight(this.highlightedIndex - 1);
      }  
    }    
  };
</script>
