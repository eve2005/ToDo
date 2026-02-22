<template>
  <div class="w-full p-4 ">
    <Alert v-if="mostrarModal" :mensagem="msg" :aoFechar="funcaoNavegacao" @fechar="mostrarModal = false"  />
    <div class="flex  justify-end   ">
    <button class=" border rounded-full border-[#9F292C] p-2 bg-[#9F292C] text-white hover:bg-white hover:text-[#9F292C] " 
                @click="mostrarFormTask">{{ mostrarCAD ? 'Cancelar' : 'Nova Tarefa' }}</button>
     
    </div>
    <div v-if="mostrarCAD" class="mb-8 flex  justify-center ">
       <NewTask  @tarefa-salva="recarregar"/> 
    </div>

    <div class="m-auto font-paytone">
        <h2 class="text-2xl text-[#9F292C] text-center ">Minhas tarefas</h2>

        <div class="flex justify-center  mb-6 mt-6" v-if="!carregando && tarefas.length > 0">
            <button @click="filtroAtual = 'todas'" :class="filtroAtual === 'todas' ? 'bg-[#9F292C] text-white' : 'bg-white text-[#9F292C]'"
                class="border border-[#9F292C] px-4 py-1 rounded-full mr-1 ">
                Todas
            </button>
            
            <button @click="filtroAtual = 'a_fazer'" :class="filtroAtual === 'a_fazer' ? 'bg-[#9F292C] text-white' : 'bg-white text-[#9F292C]'"
                class="border border-[#9F292C] px-4 py-1 rounded-full mr-1">
                A fazer
            </button>

            <button @click="filtroAtual = 'concluida'" :class="filtroAtual === 'concluida' ? 'bg-[#9F292C] text-white' : 'bg-white text-[#9F292C]'"
                class="border border-[#9F292C] px-4 py-1 rounded-full  ">
                Concluida
            </button>
        </div>

        <p class="text-center" v-if="carregando">Carregando tarefas...</p>
        <p class="text-center" v-else-if="tarefas.length === 0">Nenhuma tarefa encontrada </p>
        <p class="text-center" v-else-if="tarefasFiltradas.length === 0">Nenhuma tarefa encontrada neste filtro.</p>

        

        <div v-else>
            <div v-for="tarefa in tarefasFiltradas" :key="tarefa.id"  class=" mx-6 rounded-2xl border border-[#9F292C] font-paytone grid grid-cols-5 gap-4 mb-2" >
            
            <div class="col-span-4 p-2">
                <p class="text-2xl">Tarefa: {{ tarefa.titulo }}</p>
                <p class="text-base" v-if="tarefa.descricao != ' ' ">Descricao:{{tarefa.descricao}}</p>
            </div>

            <div class="flex items-center justify-end mr-4">
                <button @click="deletarTarefa(tarefa.id)" class=" underline  decoration-solid mr-2">excluir</button>
                <div v-if="tarefa.concluida == 0">
                    
                    <button @click="concluirTarefa(tarefa.id)" class="  p-1 rounded-2xl border border-[#9F292C] bg-[#9F292C] text-white hover:bg-white hover:text-[#9F292C]  ">concluir</button>
                </div>
                <div v-else-if="tarefa.concluida == 1">
                    <p class="text-[#9F292C]">Concluida</p>
                </div>
            </div>
            
            </div>
        </div>
    </div>

  </div>
</template>
<script setup>
    definePageMeta({
    middleware: 'authn'});

    import { ref, onMounted, computed } from 'vue';
    import NewTask from '~/components/Forms/NewTask.vue';

    import Alert from '~/components/Modal/Alert.vue';

    const token = useCookie('token');
    const mostrarCAD = ref(false);
    const tarefas = ref([]);
    const carregando = ref(true);
    const filtroAtual = ref('todas');

    const mostrarModal = ref(false);
    const msg = ref('');
    const funcaoNavegacao = ref(null);

    const tarefasFiltradas = computed(() => {
        if (filtroAtual.value === 'concluida') {
            return tarefas.value.filter(t => t.concluida == 1);
        }
        if (filtroAtual.value === 'a_fazer') {
            return tarefas.value.filter(t => t.concluida == 0);
        }
        return tarefas.value;
    });

    function recarregar(){
        carregando.value = true;
        buscarTarefas();
        mostrarCAD.value = false;
        filtroAtual.value = 'todas';
    }

    function mostrarFormTask() {
        mostrarCAD.value = !mostrarCAD.value;
    }

    async function buscarTarefas() {

        try {
            const resposta = await $fetch('http://localhost:8000/api/listTask', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json'
            }
            });
             
            tarefas.value = resposta.tarefas
        }catch(e){
            console.log("erro carregar as tarefas "+ e)
        }finally {
            carregando.value = false
        }
    }
    async function deletarTarefa(id){
        try{
            const resposta = await $fetch(`http://localhost:8000/api/excluirTask/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token.value}`,
                    'Accept': 'application/json'
                }
                });
          
            if(resposta.status == "ok"){
                 
                msg.value = "Tarefa excluida";
                funcaoNavegacao.value = () => {recarregar();};
                mostrarModal.value = true;
            }
        }catch(e){
            console.log(e);
        }
    }

    async function concluirTarefa(id){
        try{
            const resposta = await $fetch(`http://localhost:8000/api/concluirTask/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token.value}`,
                    'Accept': 'application/json'
                }
                });
          
            if(resposta.status == "ok"){
                msg.value = "Tarefa concluída com sucesso";
                funcaoNavegacao.value = () => {recarregar();};
                mostrarModal.value = true;
            }
        }catch(e){
            console.log(e);
        }
    }

    onMounted(() => {
        buscarTarefas();
    })
</script>