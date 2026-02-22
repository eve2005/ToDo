<template>
   
        
        <div class=" w-2/3 p-4  ml-3 border rounded-2xl border-[#9F292C] font-paytone ">
            <Alert v-if="mostrarModal" :mensagem="msg" :aoFechar="funcaoNavegacao" @fechar="mostrarModal = false"  />

            <form @submit.prevent="salvarTarefa">

                <div class="text-xl text-[#9F292C] w-full flex justify-center mb-3 "> 
                    <span class="  p-1 px-2">Nova Tarefa</span>
                </div>

            
                <div class="flex flex-col w-full gap-4">
                <label class=" font-paytone text-[#9F292C] flex  gap-3 mb-4" >
                        Titulo
                        <input type="text" name="titulo" v-model="novaTarefa.titulo"    
                        class="border rounded-2xl border-[#9F292C] p-1 px-2 w-2/3 flex-1 text-black" />
                    </label>
                    <div  > 
                        <label class="font-paytone text-[#9F292C] flex items-center gap-3 mb-4 ">
                            Descrição
                            <textarea class="border rounded-2xl border-[#9F292C] p-1 px-2 w-2/3 flex-1 text-black resize-none" v-model="novaTarefa.descricao"></textarea>
                        </label>
                    </div>
                </div>   
            

                <div class="  flex justify-end "> 
                    <button class=" border rounded-full border-[#9F292C] p-2 bg-[#9F292C] text-white hover:bg-white hover:text-[#9F292C]" 
                    type="submit">Adicionar Tarefa</button>
                </div>
            </form>
        </div>
    
</template>
<script setup> 
    import { ref } from 'vue';
    import Alert from '~/components/Modal/Alert.vue';

    const token = useCookie('token');
    const novaTarefa = ref({
        titulo: '',
        descricao: ''
    });
    const emit = defineEmits(['tarefaSalva']);

    const mostrarModal = ref(false);
    const msg = ref('');
    const funcaoNavegacao = ref(null);

    const processando = ref(false);

    async function salvarTarefa(){
        if (processando.value) return;
        if(!novaTarefa.value.titulo){
            msg.value = "título é obrigatório ";
            mostrarModal.value = true;
            return;
        }

        try{
            processando.value = true;
            const resposta = await $fetch('http://localhost:8000/api/newTask', {
                method: 'POST',
                headers: { 
                    'Authorization': `Bearer ${token.value}`,
                    'Accept': 'application/json', 
                    'Content-Type': 'application/json'
                },
                body: novaTarefa.value
            });
            novaTarefa.value = { titulo: '', descricao: '' };
             
            if(resposta.status == "ok"){
                msg.value = "Nova tarefa adicionada";
                funcaoNavegacao.value = () => {
                    emit('tarefaSalva');
                };
                
                mostrarModal.value = true;
            }
            

        }catch(erro){
            console.error("Dados enviados pelo Laravel:", erro.data);
        }finally{
            carregando.value = false;
        }
    }
</script>