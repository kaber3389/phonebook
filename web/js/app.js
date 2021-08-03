const app = new Vue({
    el: '#app',
    data: {
        showContacts: true,
        loading: true,
        search: '',
        oldSearch: '',
        contacts: [],
        requestComplete: false,
    },
    created: function () {
        this.loadData();
    },
    watch: {
        search: debounce(function (query) {
            this.loading = true;
            this.requestComplete = false;
            if (query && query.length > 1) {
                let searchString = query.trim().toLowerCase();
                axios.get('search', {params: {query: searchString}})
                    .then((response) => {
                        this.oldSearch = searchString;
                        this.contacts = response.data;
                        setTimeout(() => {
                            this.loading = false;
                        }, 300)
                    })
            } else {
                this.loadData();
            }
            this.requestComplete = true;
        }, 800)
    },
    methods: {
        loadData() {
            axios.get('search')
                .then((response) => {
                    this.contacts = response.data;
                    setTimeout(() => {
                        this.loading = false;
                    }, 300)
                })

            /*
            let xhr = new XMLHttpRequest();

            xhr.open('GET', 'search');
            xhr.responseType = 'json';

            xhr.send();
            xhr.onload = function() {
                this.contacts = xhr.response;
                setTimeout(() => {
                    this.loading = false;
                }, 300)
            }; */
        },
        onChangeSearch() {
            this.requestComplete = false;
        },
        toggle: function(key) {
            /*
            let el = document.getElementById("table_" + key);
            if (!el || (typeof(el) == 'undefined'))
                return false;

            el.classList.toggle('hidden');

            let i = document.getElementById("i_" + key);
            if (!i || typeof(i) == 'undefined')
                return false;

            if (i.classList.contains('glyphicon-menu-down')) {
                i.classList.remove('glyphicon-menu-down');
                i.classList.add('glyphicon-menu-up');
            } else if (i.classList.contains('glyphicon-menu-up')) {
                i.classList.remove('glyphicon-menu-up');
                i.classList.add('glyphicon-menu-down');
            } */
         },
         containsSearch(string) {
            if (!this.search || this.search.length < 2 || !string)
                return string;

            let searchString = '';
            if (!this.requestComplete)
                searchString = this.oldSearch;
            else
                searchString = this.search;

            let kws = searchString.replace(/ /g, "|");
            return string.replace(new RegExp(`(${kws})`, "gi"),
                `<span key="$1" style="color: #93C74B;">$1</span>`);
        }
    }
})

function debounce (fn, delay) {
    let timeoutID = null
    return function () {
        clearTimeout(timeoutID)
        let args = arguments
        let that = this
        timeoutID = setTimeout(function () {
            fn.apply(that, args)
        }, delay)
    }
}