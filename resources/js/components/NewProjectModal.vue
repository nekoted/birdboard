<template>
    <modal
        name="new-project-modal"
        classes="p-8 bg-card rounded"
        height="auto"
        width="50%"
        :scrollable="true"
    >
        <h1 class="mb-8 text-center text-2xl">Let's create a project !</h1>
        <form>
            <div class="flex">
                <div class="flex flex-1 flex-col mr-4">
                    <label for="title" class="mb-2 font-bold">Title</label>
                    <input
                        id="title"
                        name="title"
                        v-model="form.title"
                        placeholder="Name of your project"
                        class="mb-2 p-2 border border-muted rounded"
                    />
                    <label for="description" class="mb-2 font-bold"
                        >Description</label
                    >
                    <textarea
                        id="description"
                        name="description"
                        v-model="form.description"
                        placeholder="Describe your project."
                        class="mb-2 p-2 border border-muted rounded"
                    ></textarea>
                </div>
                <div class="flex flex-1 flex-col ml-4">
                    <label class="mb-2 font-bold">Add some tasks</label>
                    <input
                        id="task"
                        name="task"
                        placeholder="Task name ..."
                        class="mb-4 p-2 border border-muted rounded"
                    />
                    <button
                        type="button"
                        class="inline-flex items-center text-xs"
                        @click="addTask"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 18 18"
                            class="mr-2"
                        >
                            <g fill="none" fill-rule="evenodd" opacity=".307">
                                <path
                                    stroke="#000"
                                    stroke-opacity=".012"
                                    stroke-width="0"
                                    d="M-3-3h24v24H-3z"
                                ></path>
                                <path
                                    fill="#000"
                                    d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"
                                ></path>
                            </g>
                        </svg>

                        <span>Add New Task Field</span>
                    </button>
                </div>
            </div>
            <div class="flex justify-end">
                <button class="button" @click.prevent="handleSubmit">
                    Create Project
                </button>
            </div>
        </form>
    </modal>
</template>

<script>
module.exports = {
    data: function() {
        return {
            form: {
                title: "",
                description: "",
                tasks: [{ body: "" }]
            }
        };
    },
    methods: {
        handleSubmit: function() {
            axios.post("/projects", this.form).then(function(response) {
                window.location = response.data.message;
            });
        },
        addTask: function() {}
    }
};
</script>

<style scoped>
p {
    font-size: 2em;
    text-align: center;
}
</style>
