<template>
    <b-row id="top-carousel" class="bg-theme-light overflow-hidden" v-if="campaigns.length>0">
        <b-col cols="12" xl="2" class="d-none d-xl-block"></b-col>
        <b-col cols="12" xl="8" class="text-center height-30 line-height-30 nowrap">
            <splide :options="topCarousel" class="custom-arrow-transparent">
                <splide-slide v-for="campaign in campaigns" :key="campaign.id">
                    <img :src="'assets/campaigns/'+campaign.icon" class="height-30 vertical-center" />
                    <span class="excerpt width-150 vertical-center d-inline-block d-md-none"><small>{{ campaign.name }}</small></span>
                    <span class="vertical-center d-none d-md-inline-block display-9">{{ campaign.name }}</span>
                    <router-link :to="campaign.button_url" class="btn-link vertical-center">{{ campaign.button_name }}</router-link>
                </splide-slide>
            </splide>
        </b-col>
    </b-row>
</template>
<script>

export default {
    name: 'campaign',
    data() {
        return {
            topCarousel: {
                type: 'loop',
                perPage: 1,
                autoplay: true,
                focus: 'center',
                width: "100%",
                gap: '1rem',
                pagination: false,
            },
        }
    },
    props: ['campaigns']
}
</script>
