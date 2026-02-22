<template>
    
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/20 backdrop-blur-sm  ">

            <div className="relative w-full max-w-md  rounded-xl border-2 border-[#9F292C] bg-[#FDFCF5] p-8 text-center shadow-2xl ">
                
                <div className="flex flex-col items-center justify-center space-y-4">
                
                <h2 className="text-xl  text-[#9F292C] font-paytone">
                {{mensagem}}
                </h2>

                <button @click="emitirFechar" type="button"  className="mt-4 rounded-full bg-[#A52A2A] px-6 py-2  text-white  hover:bg-[#800000]">
                    Ok
                </button>
                </div>
            </div>
        </div>
      
</template>

<script setup>
    const props = defineProps({
        mensagem: { type: String },
        aoFechar: { type: Function }
    });
    const emit = defineEmits(['fechar']);

    function emitirFechar() {
        emit('fechar');
        if (props.aoFechar) {
            props.aoFechar();
        }
    }
</script>
