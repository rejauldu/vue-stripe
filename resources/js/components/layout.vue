<template>
    <div>
        <router-link v-if="$store.getters.packet>0" to="/cart" class="d-flex flex-column align-content-stretch position-center-v position-fixed right-0 z-index-999 width-60 bg-white shadow-all rounded overflow-hidden cursor-pointer hover-opacity-8 text-decoration-none">
            <div class="bg-dark text-center py-1">
                <img src="/assets/layout/cart.png" class="width-40" />
            </div>
            <div class="text-center py-2 alert-light">
                <small>{{ $store.getters.packet }} items</small>
            </div>
        </router-link>
        <div id="added-to-bag" class="d-none">
            <div class="border border-danger d-flex justify-content-center bg-warning align-items-center position-fixed left-0 top-0 right-0 z-index-9999 w-100 alert-warning shadow-lg">
                <div><img src="/assets/images/bag.png" class="width-30"/></div>
                <div class="px-4">Product added to bag</div>
            </div>
        </div>
    </div>
</template>
<script>
import router from '../router'
import store from '../store'
export default {
    data() {
        return {
            popover: false
        }
    },
    methods: {
        getUser: function () {
            axios.get('/api/user')
                .then(function (response) {
                    if (response.data && response.data.status_code == 200) {
                        store.dispatch("setUser", response.data);
                    } else if(response.data && response.data.status_code == 401) {
                        store.dispatch("changeLogin", "1");
                    } else {
                        store.dispatch("changeLogin", "0");
                    }
                })
                .catch(function (error) {
                    store.dispatch("changeLogin", "0");
                });
        },
        logout: function () {
            axios.post('/api/logout')
                .then(function (response) {
                    store.dispatch("logout");
                    router.push({name: 'login'});
                })
                .catch(function (error) {
                    store.dispatch("changeLogin", "1");
                });
        },
        search: function (event) {
            var _this = this;
            this.delay(function (e) {
                var value = event.target.value;
                if(!(_this.$route.path == '/' && value.length == 0) && (_this.$route.path !== '/search/'+value)) {
                    router.replace({name: 'search', params: {query:value} });
                }
            }, 200)();
        },
        delay: function (fn, ms) {
            let timer = 0
            return function(...args) {
                clearTimeout(timer)
                timer = setTimeout(fn.bind(this, ...args), ms || 0)
            }
        },
        routerLink: function () {
            var links = document.getElementsByClassName('router-link');
            links.forEach(this.routerLinkCb);
        },
        routerLinkCb: function(item, i) {
            var _this = this;
            item.addEventListener('click', (e)=>{
                e.preventDefault();
                var url = item.getAttribute("href");
                router.push(url).catch(()=>{});
                _this.routerLinkActivate();
            });
        },
        routerLinkActivate: function () {
            var links = document.getElementsByClassName('router-link');
            links.forEach(this.routerLinkActivateCb);
        },
        routerLinkActivateCb: function(item, i) {
            var current = router.currentRoute.path;
            var url = item.getAttribute("href");
            if(url == current) {
                item.classList.add("active");
            } else {
                item.classList.remove("active");
            }
        },
        showHidden: function () {
            var links = document.querySelectorAll('.loading.d-none');
            links.forEach(this.showHiddenCb);
        },
        showHiddenCb: function(item, i) {
            var _this = this;
            item.classList.remove('d-none');
        }
    },
    mounted() {
        this.getUser();
        store.dispatch("updateWindow");
        this.routerLink();
        this.showHidden();
        this.collapse();
        this.modal();
    }
}
import Vue from 'vue';
Vue.mixin({
    methods: {
        collapse: function() {
            var es= document.querySelectorAll('[data-toggle="collapse"]');
            es.forEach(this.collapseCb);
        },
        collapseCb: function(item, i) {
            var _this = this;
            item.addEventListener('click', (e)=>{
                e.preventDefault();
                let attr = item.getAttribute("href");
                if(!attr)
                    attr = item.getAttribute("data-target");
                attr = attr.replace('\/','');
                attr = attr.replace('\#','');
                let pid = document.getElementById(attr).getAttribute('data-parent');
                if(pid) {
                    let parent = document.querySelector(pid);
                    let c = parent.querySelector('.show[data-parent="'+pid+'"]');
                    let cid;
                    if(c) {
                        cid = c.id;
                        parent.querySelector('[href="/'+cid+'"]').removeAttribute('aria-expanded');
                        parent.querySelector('.show[data-parent="'+pid+'"]').classList.remove('show');
                    }
                }
                let expanded = item.getAttribute('aria-expanded');
                if(expanded)
                    item.removeAttribute('aria-expanded');
                else
                    item.setAttribute('aria-expanded', true);
                document.getElementById(attr).classList.toggle('show');
            });
        },
        toast: (id) => {
            var e= document.getElementById(id);
            e.classList.remove('d-none');
            setTimeout(() => {
                e.classList.add('d-none');
            }, 5000);
        },
        modal: function() {
            var es= document.querySelectorAll('[data-toggle="modal"]');
            es.forEach(this.modalCb);
            var cs= document.querySelectorAll('[data-dismiss="modal"]');
            cs.forEach(this.modalDismiss);
        },
        modalCb: function(item, i) {
            var _this = this;
            item.addEventListener('click', (e)=>{
                e.preventDefault();
                document.querySelector(item.getAttribute("data-target")).classList.add('show');
                document.querySelector('.modal-backdrop').classList.add('show');
                _this.modalClose();
            });
        },
        modalDismiss: function (item, i) {
            var _this = this;
            item.addEventListener('click', (e)=>{
                e.preventDefault();
                let t = document.querySelector('.modal.show');
                t && t.classList.remove('show');
                let c = document.querySelector('.modal-backdrop.show');
                c && c.classList.remove('show');
            });
        },
        modalClose: function() {
            let m = document.querySelector('.modal.show');
            if(m) {
                m.addEventListener("click", function(e) {
                    m && m.classList.remove('show');
                    let b = document.querySelector('.modal-backdrop.show');
                    b && b.classList.remove('show');
                });
                var c = m.querySelector('.modal-content');
                c.addEventListener('click',(e)=>{
                    let attr = e.target.getAttribute('data-dismiss');
                    if(!(attr && attr == 'modal')) {
                        e.stopPropagation();
                    }
                });
            }
        },
        modalCloseCb: function(item, i) {
            item.addEventListener('click',(e)=>{
                let attr = e.target.getAttribute('data-dismiss');
                if(!(attr && attr == 'modal')) {
                    e.stopPropagation();
                }
            });
        },
    }
})
</script>
