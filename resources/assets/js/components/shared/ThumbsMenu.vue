<template>
    <div>
        <q-btn :outline="outlineThumbsUp" :loading="loaddingIcon"  @click="thumbsUp()"  round color="green" icon="thumb_up" >
            <q-badge v-if="this.countThumbsUp>0" color="light-green-12"  floating>{{this.countThumbsUp}}</q-badge>
        </q-btn>
        <q-btn :outline="outlineThumbsDown" :loading="loaddingIcon" @click="thumbsDown()"  round color="red" icon="thumb_down">
            <q-badge  v-if="this.countThumbsDown>0" color="orange-4" floating>{{this.countThumbsDown}}</q-badge>
        </q-btn>
    </div>
</template>
<script>
    export default {
        name : "ThumbsMenu",
        data () 
        {
            return {
                loaddingIcon: false,
                outlineThumbsUp:true,
                outlineThumbsDown:true,
                countThumbsDown:0,
                countThumbsUp:0
            }
        },
        methods:{
            thumbsUp() 
            {
                if(this.save())
                {
                    this.outlineThumbsUp = !this.outlineThumbsUp;
                    if(!this.outlineThumbsUp)
                    {
                        this.outlineThumbsDown = true;
                        if( this.countThumbsDown>0)
                        this.countThumbsDown--;
                        this.countThumbsUp++;
                    }
                    else
                    {
                        this.countThumbsUp--;
                    }
                }
            },
            async thumbsDown()
            {
                if(this.save())
                {
                    this.outlineThumbsDown = !this.outlineThumbsDown;
                    if(!this.countThumbsDown)
                    {
                        this.outlineThumbsUp = true;
                        if( this.countThumbsUp>0)
                        this.countThumbsUp--;
                        this.countThumbsDown++;
                    }
                    else
                    {
                        this.countThumbsDown--;
                    }
                }
            },
            async save(likeordislike)
            {
                this.loaddingIcon = true;
                const form = new FormData();
                form.append("conteudo_id", this.$route.params.id);
                if(likeordislike)
                {
                    form.append("like", 1 );
                }
                try
                {
                    if(likeordislike)
                    {
                        let resp = await axios.post("/like" , form);
                    }
                    else if(likeordislike == false)
                    {
                        let resp = await axios.post("/dislike" , form);
                    }
                    else if(likeordislike==null)
                    {
                        let resp = await axios.post("/dislike" , form);
                    }
                }
                catch(ex)
                {
                }
                finally
                {
                    this.loaddingIcon = false
                }
                return true;
            }
        }
    };
</script>