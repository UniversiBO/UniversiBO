//
// Generated by JTB 1.3.2
//

package visitor;
import syntaxtree.*;
import java.util.*;
import java.io.*;

/**
 * Generates a syntax tree in the Scheme language.
 */
public class SchemeTreeBuilder extends DepthFirstVisitor {
   PrintWriter out;

   public SchemeTreeBuilder() {
      this(System.out);
   }

   public SchemeTreeBuilder(Writer w) {
      out = new PrintWriter(w);
   }

   public SchemeTreeBuilder(OutputStream o) {
      out = new PrintWriter(o);
   }

   private String toSchemeString(String s) {
      int len = s.length();
      StringBuffer temp = new StringBuffer(s);

      for ( int i = 0; i < len; i++ )
         if ( temp.charAt(i) == '"' ) {
            temp.insert(i, '\\');
            ++i; ++len;
         }

      return temp.toString();
   }


   public void visit(NodeList n) {
      out.print("(");
      for ( Enumeration<Node> e = n.elements(); e.hasMoreElements(); )
         e.nextElement().accept(this);
      out.print(") ");
   }

   public void visit(NodeListOptional n) {
      out.print("( ");
      for ( Enumeration<Node> e = n.elements(); e.hasMoreElements(); )
         e.nextElement().accept(this);
      out.print(") ");
   }

   public void visit(NodeOptional n) {
      out.print("(");
      if ( n.present() )
         n.node.accept(this);
      out.print(") ");
   }

   public void visit(NodeToken n) {
      out.print("\"" + toSchemeString(n.tokenImage) + "\" ");
   }


   /**
    * f0 -> ( istruzione() )*
    */
   public void visit(start n) {
      out.print("(define root '(start ");
      n.f0.accept(this);
      out.print(")) ");
      out.flush();
      out.close();
   }

   /**
    * f0 -> eventDefinition()
    *       | startDefinition()
    *       | opDefinition()
    */
   public void visit(istruzione n) {
      n.f0.accept(this);
   }

   /**
    * f0 -> <EVENT>
    * f1 -> <VARIABILE>
    * f2 -> <DEF>
    * f3 -> condition()
    * f4 -> <END>
    */
   public void visit(eventDefinition n) {
      out.print("(eventDefinition ");
      n.f0.accept(this);
      n.f1.accept(this);
      n.f2.accept(this);
      n.f3.accept(this);
      n.f4.accept(this);
      out.print(") ");
   }

   /**
    * f0 -> <STARTS>
    * f1 -> <WHEN>
    * f2 -> condition()
    * f3 -> ( <ENDS> <WHEN> condition() )?
    * f4 -> <END>
    */
   public void visit(startDefinition n) {
      out.print("(startDefinition ");
      n.f0.accept(this);
      n.f1.accept(this);
      n.f2.accept(this);
      n.f3.accept(this);
      n.f4.accept(this);
      out.print(") ");
   }

   /**
    * f0 -> <DEF_OP>
    * f1 -> <O_BRACE>
    * f2 -> <OP>
    * f3 -> <LIST_SEP>
    * f4 -> <NUM>
    * f5 -> <LIST_SEP>
    * f6 -> <NUM>
    * f7 -> <C_BRACE>
    * f8 -> <IN>
    * f9 -> listaParam()
    * f10 -> <STOP>
    * f11 -> <OUT>
    * f12 -> listaParam()
    * f13 -> <STOP>
    * f14 -> <DEF>
    * f15 -> <NS>
    * f16 -> <VARIABILE>
    * f17 -> <NSLEFT>
    * f18 -> <NSRIGHT>
    * f19 -> <END>
    */
   public void visit(opDefinition n) {
      out.print("(opDefinition ");
      n.f0.accept(this);
      n.f1.accept(this);
      n.f2.accept(this);
      n.f3.accept(this);
      n.f4.accept(this);
      n.f5.accept(this);
      n.f6.accept(this);
      n.f7.accept(this);
      n.f8.accept(this);
      n.f9.accept(this);
      n.f10.accept(this);
      n.f11.accept(this);
      n.f12.accept(this);
      n.f13.accept(this);
      n.f14.accept(this);
      n.f15.accept(this);
      n.f16.accept(this);
      n.f17.accept(this);
      n.f18.accept(this);
      n.f19.accept(this);
      out.print(") ");
   }

   /**
    * f0 -> <NOME>
    * f1 -> ( <OPEN> listaParam() <CLOSE> )?
    * f2 -> ( <STAR> )?
    * f3 -> ( <COMMA> <NOME> ( <OPEN> listaParam() <CLOSE> )? ( <STAR> )? )*
    */
   public void visit(listaParam n) {
      out.print("(listaParam ");
      n.f0.accept(this);
      n.f1.accept(this);
      n.f2.accept(this);
      n.f3.accept(this);
      out.print(") ");
   }

   /**
    * f0 -> term() ( <OP> term() )*
    *       | <OP> "(" condition() ( <LIST_SEP> condition() )* ( outputFilter() )? ")"
    */
   public void visit(condition n) {
      n.f0.accept(this);
   }

   /**
    * f0 -> <OUT>
    * f1 -> ( <OPEN> <CLOSE> )?
    * f2 -> listaParam()
    * f3 -> <STOP>
    */
   public void visit(outputFilter n) {
      out.print("(outputFilter ");
      n.f0.accept(this);
      n.f1.accept(this);
      n.f2.accept(this);
      n.f3.accept(this);
      out.print(") ");
   }

   /**
    * f0 -> "{"
    * f1 -> condition()
    * f2 -> ( <LIST_SEP> condition() )*
    * f3 -> "}"
    */
   public void visit(lista n) {
      out.print("(lista ");
      n.f0.accept(this);
      n.f1.accept(this);
      n.f2.accept(this);
      n.f3.accept(this);
      out.print(") ");
   }

   /**
    * f0 -> <DOLLARO> <VARIABILE>
    *       | namespace()
    *       | elem()
    *       | "(" condition() ")"
    *       | <AT> <VARIABILE> ( <CALL> <VARIABILE> "(" ( condition() ( "," condition() )* )? ")" )*
    *       | lista()
    */
   public void visit(term n) {
      n.f0.accept(this);
   }

   /**
    * f0 -> <NUM>
    *       | <TIME>
    *       | <STRINGA>
    */
   public void visit(elem n) {
      n.f0.accept(this);
   }

   /**
    * f0 -> <NS>
    * f1 -> <VARIABILE>
    * f2 -> <NSLEFT>
    * f3 -> <NSRIGHT>
    */
   public void visit(namespace n) {
      out.print("(namespace ");
      n.f0.accept(this);
      n.f1.accept(this);
      n.f2.accept(this);
      n.f3.accept(this);
      out.print(") ");
   }

}