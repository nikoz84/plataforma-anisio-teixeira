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
                countThumbsUp:0,
                likeOrNot:null,
                countLikes:null
            }
        },
         created() 
        {
            this.getUserLike();
            this.getCountLikes();
        },
        methods:{
            async getUserLike(){
                let resp = await axios.get("/likes/conteudo/"+this.$route.params.id+"/"+this.getTipo());
                if (resp.data.success) {
                    this.likeOrNot = resp.data.metadata;
                }
                if( this.likeOrNot.like)
                {
                    this.outlineThumbsUp = false;
                }
                if(this.likeOrNot.like === false)
                {
                    this.outlineThumbsDown = false;
                }
            },
            async getCountLikes()
            {
                 let resp = await axios.get("/likes/count/"+this.$route.params.id+"/"+this.getTipo());
                 if (resp.data.success) {
                    this.countLikes = resp.data.metadata;
                    this.countThumbsDown = this.countLikes.dislikes;
                    this.countThumbsUp =   this.countLikes.likes;
                }
            },
            getTipo()
            {
                if(this.$route.path.indexOf("/conteudo/")>=0)
                {
                    return "conteudo";
                }
                else if(this.$route.path.indexOf("/aplicativo/")>=0)
                {
                    return "aplicativo";
                }
            },
            thumbsUp() 
            {
                if(this.save(true))
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
                if(this.save(false))
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
                if(this.$route.path.indexOf("/conteudo/")>=0)
                {
                    form.append("conteudo_id", this.$route.params.id);
                    form.append("tipo", "conteudo");
                }
                else if((this.$route.path.indexOf("/aplivativo/")>=0))
                {
                    form.append("aplicativo_id", this.$route.params.id);
                    form.append("tipo", "aplicativo");
                }
                form.append("user_id", "");
                if(likeordislike)
                {
                    form.append("like", 1 );
                }
                else if(likeordislike)
                {
                    form.append("like", 0 );
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
                        let resp = await axios.delete("/dislike" , form);
                    }
                }
                catch(ex)
                {
                    this.errors = ex.errors;
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