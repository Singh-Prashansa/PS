/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 */

package com.mycompany.tictactoe;

/**
 *
 * @author Thinkpad
 */
import java.awt.*;
import javax.swing.*;
import java.awt.event.*;

public class TicTacToe {
    int boardWidth=600;
    int boardHeight=650;
    
    JFrame frame= new JFrame("tic-tac-toe");
    JLabel textLabel= new JLabel();
    JPanel textPanel= new JPanel();
    JPanel boardPanel= new JPanel();
    JButton[][] board= new JButton[3][3];
    JButton reset=new JButton("restart");
    
    String playerX="X";
    String playerO="O";
    String currentPlayer=playerO;

    boolean gameOver=false;
    int turns=0;
    
    TicTacToe(){
        frame.setVisible(true);
        frame.setSize(boardWidth,boardHeight);
        frame.setLocationRelativeTo(null);
        frame.setResizable(false);
        frame.setLayout(new BorderLayout());
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        
        
        textLabel.setBackground(Color.lightGray);
        textLabel.setForeground(Color.BLACK);
        textLabel.setFont(new Font("Arial", Font.BOLD, 40));
        textLabel.setHorizontalAlignment(JLabel.CENTER);
        textLabel.setText("tic-tac-toe");
//        textLabel.setOpaque(true);
        
        textPanel.setLayout(new GridLayout(1,2));
        textPanel.add(textLabel);
        frame.add(textPanel, BorderLayout.NORTH);
        
        
        boardPanel.setLayout(new GridLayout(3,3));
        boardPanel.setBackground(Color.lightGray);
        frame.add(boardPanel);
        
        reset.setForeground(Color.YELLOW);
        reset.setBackground(Color.DARK_GRAY);
        textPanel.add(reset);
        
        for(int r=0;r<3;r++){
            for(int c=0;c<3;c++){
               JButton tile=new JButton ();
               board[r][c]=tile;
               boardPanel.add(tile);
               tile.setFont(new Font("Arial",Font.BOLD,100));
               tile.setBackground(Color.lightGray);
               tile.setForeground(Color.WHITE);
                tile.addActionListener(new ActionListener(){
                    public void actionPerformed(ActionEvent e){
                        if (gameOver) return;
                        JButton tile=(JButton)e.getSource();
                        if(tile.getText() == ""){
                            tile.setText(currentPlayer);
                            turns++;
                            checkWinner();
                            if(!gameOver){
                                currentPlayer=currentPlayer==playerX?playerO:playerX;
                                textLabel.setText(currentPlayer+"'s turn");
                            }
                        }
                    }
                });
            } 
        } 
        
//        reset
        reset.addActionListener(new ActionListener(){
                    public void actionPerformed(ActionEvent e){                       
                        for(int r=0;r<3;r++){
                            for(int c=0;c<3;c++){
                               board[r][c].setText("");
                            }
                        }
                        textLabel.setText("tic-tac-toe");
                        turns=0;
                        gameOver=false;
                    }
                });
    }
    void checkWinner(){
//        horizontal
        for(int r=0 ;r<3;r++){
            if(board[r][0].getText()=="") continue;
            if(board[r][0].getText() == board[r][1].getText() &&
               board[r][1].getText() == board[r][2].getText()){
                for(int i=0;i<3;i++){
                    setWinner(board[r][i]);
                }
                gameOver=true;
                return;
            }                
        }
//        vertical
        for(int c=0 ;c<3;c++){
            if(board[0][c].getText()=="") continue;
            if(board[0][c].getText() == board[1][c].getText() &&
               board[1][c].getText() == board[2][c].getText()){
                for(int i=0;i<3;i++){
                    setWinner(board[i][c]);
                }
                gameOver=true;
                return;
            }                
        }
//        diagonal
        if(board[0][0].getText() == board[1][1].getText() &&
           board[1][1].getText() == board[2][2].getText() &&
           board[0][0].getText()!=""){
            for(int i=0;i<3;i++){
                    setWinner(board[i][i]);
                }
            gameOver=true;
            return;
        }  
//        anit-diagonal
        if(board[0][2].getText() == board[1][1].getText() &&
           board[1][1].getText() == board[2][0].getText() &&
           board[0][2].getText()!=""){
               setWinner(board[0][2]);
               setWinner(board[1][1]);
               setWinner(board[2][0]);
            gameOver=true;
            return;
        }  
        
//        tie or not
        if(turns==9){
            tie();
        }
       
    }
    void setWinner(JButton tile){
        tile.setForeground(Color.GREEN);
        textLabel.setText(currentPlayer+" is the winner");
    }
    void tie(){
        for(int i=0;i<3;i++){
            for(int j =0;j<3;j++){
                board[i][j].setForeground(Color.RED);
            }
        }
        textLabel.setText("It's a tie");
        gameOver=true;
        return;
    }
    
    
     public static void main(String[] args)  {
        new TicTacToe();
    }
}
