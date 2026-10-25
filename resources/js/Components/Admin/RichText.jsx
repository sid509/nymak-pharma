import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faBold, faHeading, faItalic, faLink, faLinkSlash, faList, faListOl, faMinus, faQuoteLeft, faRotateLeft, faRotateRight, faStrikethrough, faTextSlash, faUnderline } from '@fortawesome/free-solid-svg-icons';
import Link from '@tiptap/extension-link';
import { EditorContent, useEditor, useEditorState } from '@tiptap/react';
import StarterKit from '@tiptap/starter-kit';

import { useEffect } from 'react';

/**
 * WYSIWYG editor (TipTap) for admin HTML fields. Emits HTML on every change;
 * the server sanitises it again before storing (App\Support\Html), so the
 * toolbar is a convenience, not the security boundary.
 */
export default function RichText({ id, value = '', onChange, placeholder = 'Write here…' }) {
    const editor = useEditor({
        extensions: [
            StarterKit.configure({
                heading: { levels: [2, 3] },
                code: false,
                codeBlock: false,
                link: false,
            }),
            Link.configure({
                openOnClick: false,
                autolink: true,
                defaultProtocol: 'https',
                HTMLAttributes: { rel: 'noopener noreferrer', target: '_blank' },
            }),
        ],
        content: value || '',
        immediatelyRender: false,
        editorProps: {
            attributes: {
                id,
                class: 'richtext-body prose-nymak min-h-[14rem] px-4 py-3 text-sm focus:outline-none',
                'data-placeholder': placeholder,
            },
        },
        onUpdate: ({ editor: e }) => onChange(e.isEmpty ? '' : e.getHTML()),
    });

    // Keep the editor in sync if the parent resets the value (e.g. form reset).
    useEffect(() => {
        if (editor && (value || '') !== editor.getHTML() && !(editor.isEmpty && !value)) {
            editor.commands.setContent(value || '', { emitUpdate: false });
        }
    }, [value, editor]);

    // TipTap v3 doesn't re-render on every transaction; subscribe to just the
    // state the toolbar paints so active buttons track the cursor.
    // Note: the snapshot only populates after the first transaction, so fall
    // back to an inactive toolbar rather than blocking the editor mount.
    const st = useEditorState({
        editor,
        selector: ({ editor: e }) => (e ? {
            bold: e.isActive('bold'), italic: e.isActive('italic'), underline: e.isActive('underline'), strike: e.isActive('strike'),
            h2: e.isActive('heading', { level: 2 }), h3: e.isActive('heading', { level: 3 }),
            bullet: e.isActive('bulletList'), ordered: e.isActive('orderedList'), quote: e.isActive('blockquote'),
            link: e.isActive('link'), canUndo: e.can().undo(), canRedo: e.can().redo(),
        } : null),
    }) ?? {};

    if (!editor) {
        return <div className="richtext min-h-[17rem] animate-pulse rounded-lg border border-ink-200 bg-ink-50" aria-hidden />;
    }

    const setLink = () => {
        const previous = editor.getAttributes('link').href || '';
        const url = window.prompt('Link URL', previous);
        if (url === null) return;
        if (url.trim() === '') {
            editor.chain().focus().extendMarkRange('link').unsetLink().run();
            return;
        }
        editor.chain().focus().extendMarkRange('link').setLink({ href: url.trim() }).run();
    };

    const Btn = ({ onClick, active = false, disabled = false, label, children }) => (
        <button type="button" onClick={onClick} disabled={disabled} aria-label={label} title={label}
                aria-pressed={active} onMouseDown={(e) => e.preventDefault()} // keep selection + focus in the editor
                className={`rounded-md p-1.5 text-ink-600 transition-colors hover:bg-ink-100 hover:text-ink-900 disabled:opacity-40 disabled:hover:bg-transparent ${
                    active ? 'bg-brand-50 text-brand-800' : ''}`}>
            {children}
        </button>
    );
    const Sep = () => <span className="mx-1 h-5 w-px bg-ink-200" aria-hidden />;

    return (
        <div className="richtext overflow-hidden rounded-lg border border-ink-200 bg-white transition-colors focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-100">
            <div role="toolbar" aria-label="Formatting" className="flex flex-wrap items-center gap-0.5 border-b border-ink-100 bg-ink-50/60 px-2 py-1.5">
                <Btn label="Bold" active={st.bold} onClick={() => editor.chain().focus().toggleBold().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faBold} /></Btn>
                <Btn label="Italic" active={st.italic} onClick={() => editor.chain().focus().toggleItalic().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faItalic} /></Btn>
                <Btn label="Underline" active={st.underline} onClick={() => editor.chain().focus().toggleUnderline().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faUnderline} /></Btn>
                <Btn label="Strikethrough" active={st.strike} onClick={() => editor.chain().focus().toggleStrike().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faStrikethrough} /></Btn>
                <Sep />
                <Btn label="Heading" active={st.h2} onClick={() => editor.chain().focus().toggleHeading({ level: 2 }).run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faHeading} /></Btn>
                <Btn label="Subheading" active={st.h3} onClick={() => editor.chain().focus().toggleHeading({ level: 3 }).run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faHeading} /></Btn>
                <Sep />
                <Btn label="Bullet list" active={st.bullet} onClick={() => editor.chain().focus().toggleBulletList().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faList} /></Btn>
                <Btn label="Numbered list" active={st.ordered} onClick={() => editor.chain().focus().toggleOrderedList().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faListOl} /></Btn>
                <Btn label="Quote" active={st.quote} onClick={() => editor.chain().focus().toggleBlockquote().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faQuoteLeft} /></Btn>
                <Btn label="Divider" onClick={() => editor.chain().focus().setHorizontalRule().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faMinus} /></Btn>
                <Sep />
                <Btn label="Add link" active={st.link} onClick={setLink}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faLink} /></Btn>
                <Btn label="Remove link" disabled={!st.link} onClick={() => editor.chain().focus().unsetLink().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faLinkSlash} /></Btn>
                <Btn label="Clear formatting" onClick={() => editor.chain().focus().clearNodes().unsetAllMarks().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faTextSlash} /></Btn>
                <Sep />
                <Btn label="Undo" disabled={!st.canUndo} onClick={() => editor.chain().focus().undo().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faRotateLeft} /></Btn>
                <Btn label="Redo" disabled={!st.canRedo} onClick={() => editor.chain().focus().redo().run()}><FontAwesomeIcon style={{ fontSize: 15 }} icon={faRotateRight} /></Btn>
            </div>
            <EditorContent editor={editor} />
        </div>
    );
}
